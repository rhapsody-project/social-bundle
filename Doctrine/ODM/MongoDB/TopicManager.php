<?php
/* Copyright (c) 2015 Rhapsody Project
 *
 * Licensed under the MIT License (http://opensource.org/licenses/MIT)
 *
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
 * KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
 * OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Rhapsody\SocialBundle\Doctrine\ODM\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Monolog\Logger;
use Rhapsody\SocialBundle\Doctrine\PostManagerInterface;
use Rhapsody\SocialBundle\Doctrine\TopicManagerInterface;
use Rhapsody\SocialBundle\Event\TopicEventBuilder;
use Rhapsody\SocialBundle\Factory\BuilderFactoryInterface;
use Rhapsody\SocialBundle\Form\Factory\FactoryInterface;
use Rhapsody\SocialBundle\Model\PostInterface;
use Rhapsody\SocialBundle\Model\SocialContextInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Rhapsody\SocialBundle\RhapsodySocialEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Doctrine\ODM\MongoDB
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicManager implements TopicManagerInterface
{
	/**
	 * Whether or not to automatically flush changes after a persistence
	 * operation is performed.
	 * @var boolean
	 * @access protected
	 */
	protected $autoFlush = true;

	/**
	 * The logging device.
	 * @var \Monolog\Logger
	 * @access protected
	 */
	protected $logger;

	/**
	 * The event dispatcher.
	 * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
	 * @access protected
	 */
	protected $eventDispatcher;

	/**
	 * The object manager.
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 * @access protected
	 */
	protected $objectManager;

	/**
	 * @var \Rhapsody\SocialBundle\Doctrine\PostManagerInterface
	 * @access protected
	 */
	protected $postManager;

	/**
	 * The repository.
	 * @var \Doctrine\ODM\MongoDB\DocumentRepository
	 * @access protected
	 */
	protected $repository;

	/**
	 * The class builder factory.
	 * @var \Rhapsody\SocialBundle\Factory\BuilderFactoryInterface
	 * @access protected
	 */
	protected $builderFactory;

	/**
	 * The form factory.
	 * @var \Rhapsody\SocialBundle\Form\Factory\FactoryInterface
	 */
	protected $formFactory;

	/**
	 * The class.
	 * @var string
	 * @access protected
	 */
	protected $class;

	public function __construct(
			ObjectManager $objectManager,
			EventDispatcherInterface $eventDispatcher,
			BuilderFactoryInterface $builderFactory,
			FactoryInterface $formFactory,
			PostManagerInterface $postManager,
			$class)
	{
		$repository = $objectManager->getRepository($class);
		$metadata = $objectManager->getClassMetadata($class);

		$this->class = $metadata->getName();
		$this->repository = $repository;
		$this->eventDispatcher = $eventDispatcher;
		$this->objectManager = $objectManager;
		$this->postManager = $postManager;
		$this->builderFactory = $builderFactory;
		$this->formFactory = $formFactory;

		$this->logger = new Logger(get_class($this));
	}

	/**
	 *
	 */
	public function newTopic(SocialContextInterface $socialContext, $category = null)
	{
		$topic = $this->createTopicBuilder()
			->setSocialContext($socialContext)
			->setCategory($category)
			->build();
		return $topic;
	}

	public function createTopic(TopicInterface $topic, PostInterface $post, $user)
	{
		$socialContext = $topic->getSocialContext();

		// ** Set post properties.
		$this->logger->debug("Assigning author and topic reference to post.");
		$post->setAuthor($user);
		$post->setTopic($topic);
		$post->setSocialContext($socialContext);

		// ** Set topic properties.
		$this->logger->debug("Creating reference to post on topic.");
		$topic->setPost($post);
		$topic->setLastPost($post);
		$topic->setUser($user);

		// ** Update/persist the topic.
		$this->update($topic);
		return $topic;
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManagerInterface::createTopicBuilder()
	 */
	public function createTopicBuilder()
	{
		return $this->builderFactory->createBuilder();
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManagerInterface::findBySlug()
	 */
	public function findById($id)
	{
		return $this->repository->findById($id);
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManagerInterface::findBySlug()
	 */
	public function findBySlug($slug)
	{
		return $this->repository->findBySlug($slug);
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManagerInterface::findAll()
	 */
	public function findAll(SocialContextInterface $socialContext)
	{
		return $this->repository->findAllBySocialContext($socialContext);
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManagerInterface::findAll()
	 */
	public function findAllByCategory(SocialContextInterface $socialContext, $category)
	{
		return $this->repository->findAllByCategory($socialContext, $category);
	}

	/**
	 * Returns an array of users who have commented on this action.
	 *
	 * @return array an array of users who have commented on this action.
	 */
	public function findUsersByTopic($topic)
	{
		$users = array();
		$posts = $this->postManager->findAllByTopic($topic);

		// ** Add the rest of the commentors...
		foreach ($posts as $post) {
			try {
				$key = $post->author->getId();
				if (!array_key_exists($key, $users)) {
					$users[$key] = $post->author;
				}
			}
			finally {
				// Do nothing
			}
		}
		return array_values($users);
	}

	public function getFormFactory()
	{
		return $this->formFactory;
	}

	public function markTopicAsViewed(TopicInterface $topic, UserInterface $user)
	{
		$this->repository->incrementTopicNumViews($topic);
	}

	/**
	 *
	 */
	public function remove(TopicInterface $topic, $andFlush = true)
	{
		$category = $topic->getCategory();

		$this->logger->debug(sprintf('Removing all posts associated with topic: %s.', $topic->getId()));
		$posts = $this->TopicManager->findAllByTopic($topic);
		$this->TopicManager->removeAll($posts);

		$this->logger->debug(sprintf('Removing topic: %s.', $topic->getId()));
		$this->objectManager->remove($topic);
		if ($andFlush) {
			$this->objectManager->flush();
			//$this->categoryUpdater->update($category);
		}
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManagerInterface::search()
	 */
	public function search($query, $paginate = true)
	{
		return $this->repository->search($query, $paginate);
	}

	/**
	 * Trigger an event upon replying to a topic.
	 *
	 * @param TopicInterface $topic the topic being viewed.
	 * @param mixed $user the user viewing the event.
	 * @param string $eventName the event name.
	 */
	public function replyToTopic(TopicInterface $topic, PostInterface $post, $user, $eventName = RhapsodySocialEvents::REPLY_TO_TOPIC)
	{
		$topicEventBuilder = TopicEventBuilder::create()
			->setTopic($topic)
			->setPost($post)
			->setUser($post->author);
		$event = $topicEventBuilder->build();
		$this->eventDispatcher->dispatch($eventName, $event);
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManagerInterface::update()
	 */
	public function update(TopicInterface $topic, $andFlush = true)
	{
		$this->objectManager->persist($topic);
		if ($andFlush) {
			$this->objectManager->flush();
		}
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\TopicManagerInterface::update()
	 */
	public function updateCounts(TopicInterface $topic)
	{
		$posts = $this->postManager->getPostCountByTopic($topic);

		$topic->setPostCount($posts);
		$topic->setReplyCount($posts - 1);
		$this->update($topic);
	}

	/**
	 * Trigger an event upon viewing a topic.
	 *
	 * @param TopicInterface $topic the topic being viewed.
	 * @param mixed $user the user viewing the event.
	 * @param string $eventName the event name.
	 */
	public function viewTopic(TopicInterface $topic, $user, $eventName = RhapsodySocialEvents::VIEW_TOPIC)
	{
		$topicEventBuilder = TopicEventBuilder::create()
			->setTopic($topic)
			->setUser($user);
		$event = $topicEventBuilder->build();
		$this->eventDispatcher->dispatch($eventName, $event);
	}

}
