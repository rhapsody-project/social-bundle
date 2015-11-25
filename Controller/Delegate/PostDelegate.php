<?php
/* Copyright (c) 2013 Rhapsody Project
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
namespace Rhapsody\SocialBundle\Controller\Delegate;

use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Rhapsody\ComponentExtensionBundle\Exception\FormExceptionFactory;
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Rhapsody\SocialBundle\Doctrine\PostManagerInterface;
use Rhapsody\SocialBundle\Doctrine\TopicManagerInterface;
use Rhapsody\SocialBundle\Form\Factory\FactoryInterface;
use Rhapsody\SocialBundle\Model\PostInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Controller\Delegate
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class PostDelegate extends Delegate
{

	/**
	 *
	 * @var \Rhapsody\SocialBundle\Doctrine\PostManagerInterface
	 */
	private $postManager;

	/**
	 *
	 * @var \Rhapsody\SocialBundle\Doctrine\TopicManagerInterface
	 */
	private $topicManager;

	public function __construct(PostManagerInterface $postManager, TopicManagerInterface $topicManager)
	{
		parent::__construct();
		$this->postManager = $postManager;
		$this->topicManager = $topicManager;
	}

	/**
	 * Delegate for rendering the page that allows a user to create a new post
	 * within a topic.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\SocialBundle\Model\TopicInterface $topic the topic.
	 * @return array an array of responses composed of the <code>$topic</code>,
	 *     <code>$post</code>, and the <code>$response</code>.
	 */
	public function createAction(Request $request, TopicInterface $topic)
	{
		/** @var $user \Symfony\Component\Security\Core\User\UserInterface */
		$user = $this->getUser();

		/** @var $topic \Rhapsody\SocialBundle\Model\TopicInterface */
		$post = $this->postManager->newPost($topic);

		$formFactory = $this->postManager->getFormFactory();
		$form = $formFactory->create();
		$form->setData($post);
		$form->handleRequest($request);
		$data = $form->getData();

		if (!$form->isValid()) {
			$view = View::create(array('topic' => $topic, 'post' => $data, 'form' => $form->createView()))
				->setFormat($request->getRequestFormat('html'))
				->setSerializationContext(SerializationContext::create()->setGroups('context'))
				->setTemplate('RhapsodySocialBundle:Topic:reply.html.twig');
			throw FormExceptionFactory::create('The form is invalid.')->setForm($form)->setView($view)->build();
		}

		$post = $this->postManager->createPost($data, $topic, $user);

		$topic->setLastUpdated($post->getCreated());
		$topic->setLastPost($data);
		$this->topicManager->update($topic);

		$this->container->get('session')->getFlashBag()->add('success', 'rhapsody.forum.post.created');
		$view = RouteRedirectView::create('rhapsody_forum_topic_view', array('topic' => $topic->id, 'post' => $post->id))
			->setFormat($request->getRequestFormat('html'));
		$response = $this->createResponseBuilder($view);
		return array($topic, $post, $response);
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\SocialBundle\Model\TopicInterface $topic the topic.
	 * @param \Rhapsody\SocialBundle\Model\PostInterface $post the post.
	 * @return array an array of responses composed of the <code>$topic</code>,
	 *     <code>$post</code>, and the <code>$response</code>.
	 */
	public function deleteAction(Request $request, TopicInterface $topic, PostInterface $post)
	{
		if (empty($topic)) {
			throw new \InvalidArgumentException("Unable to delete post, no topic defined.");
		}

		if (empty($post)) {
			throw new \InvalidArgumentException("Unable to delete post, no post specified.");
		}

		$this->postManager->remove($post);
		// TODO: Update topic statistics.
		$view = RouteRedirectView::create('rhapsody_forum_topic_view', array('topic' => $topic->id))
			->setFormat($request->getRequestFormat('html'));
		$response = $this->createResponseBuilder($view);
		return array($topic, $post, $response);
	}

	/**
	 * Delegate for rendering the page that allows the user to post a new topic to
	 * the forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\SocialBundle\Model\TopicInterface $topic the topic.
	 * @param \Rhapsody\SocialBundle\Model\PostInterface $post the post.
	 * @return array an array of responses composed of the <code>$topic</code>,
	 *     <code>$post</code>, and the <code>$response</code>.
	 */
	public function editAction(Request $request, TopicInterface $topic, PostInterface $post)
	{
		$formFactory = $this->postManager->getFormFactory();
		$form = $formFactory->create();
		$form->setData($post);

		$view = View::create(array('topic' => $topic, 'post' => $post, 'form' => $form->createView()))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodySocialBundle:Post:edit.html.twig');
		$response = $this->createResponseBuilder($view);
		return array($topic, $post, $response);
	}

	public function flagAction(Request $request, TopicInterface $topic, PostInterface $post)
	{
		throw new \Exception("Not yet implemented");
	}

	public function shareAction(Request $request, TopicInterface $topic, PostInterface $post)
	{
		throw new \Exception("Not yet implemented");
	}

	/**
	 * Delegate for rendering the page that allows the user to post a new topic to
	 * the forum.
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\SocialBundle\Model\TopicInterface $topic the topic.
	 * @param \Rhapsody\SocialBundle\Model\PostInterface $post the post.
	 * @return array an array tuple of the <code>$topic</code> the updated
	 *     <code>$post</code> and the <code>$response</code>
	 */
	public function updateAction(Request $request, TopicInterface $topic, PostInterface $post)
	{
		/** @var $user \Symfony\Component\Security\Core\User\UserInterface */
		$user = $this->getUser();

		$formFactory = $this->postManager->getFormFactory();
		$form = $formFactory->create();
		$form->setData($post);
		$form->handleRequest($request);
		$data = $form->getData();

		if (!$form->isValid()) {
			$view = View::create(array('topic' => $topic, 'post' => $data, 'form' => $form->createView()))
				->setFormat($request->getRequestFormat('html'))
				->setSerializationContext(SerializationContext::create()->setGroups('context'))
				->setTemplate('RhapsodySocialBundle:Topic:reply.html.twig');
			throw FormExceptionFactory::create('The form is invalid.')->setForm($form)->setView($view)->build();
		}

		$data->editCount += 1;
		$data->lastUpdated = new \DateTime;
		$this->postManager->update($data);

		$view = RouteRedirectView::create('rhapsody_forum_topic_view', array('topic' => $topic->id, 'post' => $data->id))
			->setFormat($request->getRequestFormat('html'));
		$response = $this->createResponseBuilder($view);
		return array($topic, $data, $response);
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param \Rhapsody\SocialBundle\Model\TopicInterface $topic the topic.
	 * @param \Rhapsody\SocialBundle\Model\PostInterface $post the post.
	 * @return array an array of responses composed of the <code>$topic</code>,
	 *     <code>$post</code>, and the <code>$response</code>.
	 */
	public function viewAction($request, TopicInterface $topic, PostInterface $post)
	{
		throw new \Exception('Not yet implemented');
		//return array($topic, $post, $response);
	}
}
