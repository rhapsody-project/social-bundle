<?php
/* Copyright (c) Rhapsody Project
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
namespace Rhapsody\SocialBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Monolog\Logger;
use Rhapsody\SocialBundle\Factory\BuilderFactoryInterface;
use Rhapsody\SocialBundle\Form\Factory\FactoryInterface;
use Rhapsody\SocialBundle\Model\PostInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Doctrine\ODM\MongoDB
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class PostManager implements PostManagerInterface
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
     * The repository.
     * @var \Rhapsody\SocialBundle\Repository\PostRepositoryInterface
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
            $class)
    {
        $repository = $objectManager->getRepository($class);
        $metadata = $objectManager->getClassMetadata($class);

        $this->class = $metadata->getName();
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
        $this->objectManager = $objectManager;
        $this->builderFactory = $builderFactory;
        $this->formFactory = $formFactory;

        $this->logger = new Logger(get_class($this));
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::countPosts()
     */
    public function countPosts(TopicInterface $topic)
    {
        return $this->repository->countPostsByTopic($topic);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::countReplies()
     */
    public function countReplies(TopicInterface $topic)
    {
        return $this->repository->countRepliesByTopic($topic);
    }

    public function createPostBuilder()
    {
        return $this->builderFactory->createBuilder();
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::createPost()
     */
    public function createPost(PostInterface $post, TopicInterface $topic, $user)
    {
        $socialContext = $topic->getSocialContext();

        $post->setAuthor($user);
        $post->setSocialContext($socialContext);
        $post->setTopic($topic);

        $this->update($post);
        return $post;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::findAllByTopic()
     */
    public function findAllByTopic(TopicInterface $topic)
    {
        return $this->findByTopic($topic);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::findRecentByTopic()
     */
    public function findRecentByTopic(TopicInterface $topic, $limit = 10)
    {
        return $this->repository->findRecentByTopic($topic, $limit);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::findById()
     */
    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::findBySlug()
     */
    public function findBySlug($slug)
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::findByTopic()
     */
    public function findByTopic(TopicInterface $topic, $limit = null, $offset = 0)
    {
        return $this->repository->findByTopic($topic, $limit, $offset);
    }

    public function findPageByTopicAndPost(TopicInterface $topic, PostInterface $post, $limit = 10)
    {
        if ($limit < 1) {
            throw new \InvalidArgumentException('Limit must be a value greater than or equal to 1.');
        }
        $position = $this->repository->findPositionByTopicAndPost($topic, $post);
        return ceil($position / $limit);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::findRepliesByTopic()
     */
    public function findRepliesByTopic(TopicInterface $topic, $limit = null, $offset = 0)
    {
        return $this->repository->findRepliesByTopic($topic, $limit, $offset);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Doctrine\PostManagerInterface::getFormFactory()
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    public function getPostCountByTopic($topic)
    {
        return $this->repository->getPostCountByTopic($topic);
    }

    /**
     *
     */
    public function newPost(TopicInterface $topic)
    {
        $post = $this->createPostBuilder()
            ->setTopic($topic)
            ->build();
        return $post;
    }

    public function quoteText(PostInterface $post)
    {
        return $post->getText();
    }

    /**
     * (non-PHPDoc)
     * @see Rhapsody\SocialBundle\Doctrine\PostManagerInterface::search()
     */
    public function search($query)
    {
        return $this->repository->search($query);
    }

    /**
     * (non-PHPDoc)
     * @see Rhapsody\SocialBundle\Doctrine\PostManagerInterface::updatePost()
     */
    public function update(PostInterface $post, $andFlush = true)
    {
        $this->objectManager->persist($post);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

}
