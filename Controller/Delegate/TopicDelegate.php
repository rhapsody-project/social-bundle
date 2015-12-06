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
use Rhapsody\SocialBundle\Event\TopicEventBuilder;
use Rhapsody\SocialBundle\Form\Factory\FactoryInterface;
use Rhapsody\SocialBundle\Model\SocialContextInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Rhapsody\SocialBundle\Model\PostInterface;

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
class TopicDelegate extends Delegate
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

	public function __construct(TopicManagerInterface $topicManager, PostManagerInterface $postManager)
	{
		parent::__construct();
		$this->topicManager = $topicManager;
		$this->postManager = $postManager;
	}

	/**
	 * Delegate for rendering the page that allows the user to post a new topic to
	 * the forum.
	 *
	 * @param Request $request the request.
	 * @param SocialContextInterface $socialContext the social context.
	 * @param mixed $category Optional. The category for the topic.
	 */
	public function createAction($request, SocialContextInterface $socialContext, $category = null)
	{
		/** @var $user \Symfony\Component\Security\Core\User\UserInterface */
		$user = $this->getUser();

		/** @var $topic \Rhapsody\SocialBundle\Model\TopicInterface */
		$topic = $this->topicManager->newTopic($socialContext, $category);

		$formFactory = $this->topicManager->getFormFactory();
		$form = $formFactory->create();
		$form->setData($topic);
		$form->handleRequest($request);
		$data = $form->getData();

		if (!$form->isValid()) {
			$view = View::create(array('socialContext' => $socialContext, 'category' => $category,'topic' => $data, 'form' => $form->createView()))
				->setFormat($request->getRequestFormat('html'))
				->setSerializationContext(SerializationContext::create()->setGroups('context'))
				->setTemplate('RhapsodySocialBundle:Topic:new.html.twig');
			throw FormExceptionFactory::create('The form is invalid.')->setForm($form)->setView($view)->build();
		}

		$post = $form->get('post')->getData();
		$topic = $this->topicManager->createTopic($data, $post, $user);

		$this->container->get('session')->getFlashBag()->add('success', 'rhapsody.forum.topic.created');
		$view = RouteRedirectView::create('rhapsody_social_topic_view', array('topic' => $data->getId()))
			->setFormat($request->getRequestFormat('html'));
		$response = $this->createResponseBuilder($view);
		return array($topic, $post, $response);
	}

	/**
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $request The request.
	 * @param string $id The topic identifier.
	 * @throws NotFoundHttpException
	 */
	public function deleteAction(Request $request, TopicInterface $topic)
	{
		$this->topicManager->remove($topic);
		return $this->createResponseBuilder($view);
	}

	/**
	 * Handles a request for a list of topics, either all topics or those within
	 * a specific category.
	 *
	 * @param Request $request the request.
	 * @param SocialContextInterface $socialContext the social context.
	 * @param int $pageSize the number of topics per page.
	 * @return array the topics and the response.
	 */
	public function listAction(Request $request, SocialContextInterface $socialContext, $pageSize = 10)
	{
		/** @var $paginator \Knp\Components\Pager\Paginator */
		$paginator = $this->container->get('knp_paginator');

		$page = $request->query->get('page', 1);
		$topics = $this->topicManager->findAll($socialContext);
		$pagination = $paginator->paginate($topics, $page, $pageSize);

		$view = View::create(array('topics' => $pagination, 'page' => $page))
			->setFormat($request->getRequestFormat('html'))
			->setTemplate('RhapsodySocialBundle:Topic:list.html.twig');
		$response = $this->createResponseBuilder($view);
		return array($topics, $response);
	}

	/**
	 * Delegate for posting a new topic to the forum.
	 *
	 * @param Request $request The request.
	 * @param SocialContextInterface $forum The social context.
	 */
	public function newAction(Request $request, SocialContextInterface $socialContext)
	{
		/** @var $topic \Rhapsody\SocialBundle\Model\TopicInterface */
		$topic = $this->topicManager->newTopic($socialContext);

		$formFactory = $this->topicManager->getFormFactory();
		$form = $formFactory->create();
		$form->setData($topic);

		$view = View::create(array('socialContext' => $socialContext, 'topic' => $topic,'form' => $form->createView()))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodySocialBundle:Topic:new.html.twig');
		$response = $this->createResponseBuilder($view);
		return array($topic, $response);
	}

	/**
	 * Delegate for posting a reply to a topic in a forum.
	 *
	 * @param Request $request The request.
	 * @param SocialContextInterface $forum The social context.
	 * @param TopicInterface $topic The topic.
	 * @param PostInterface $post
	 */
	public function replyAction(Request $request, SocialContextInterface $socialContext, TopicInterface $topic, $post = null)
	{
		/** @var $post \Rhapsody\SocialBundle\Model\PostInterface */
		$reply = $this->postManager->newPost($topic);

		if ($request->query->getBoolean('quote', false)) {
			$reply->text = $this->postManager->quoteText($post);
		}

		$formFactory = $this->postManager->getFormFactory();
		$form = $formFactory->create();
		$form->setData($reply);

		$posts = $this->postManager->findRecentByTopic($topic);

		$view = View::create(array('socialContext' => $socialContext, 'topic' => $topic, 'post' => $reply, 'posts' => $posts, 'form' => $form->createView()))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodySocialBundle:Topic:reply.html.twig');
		$response = $this->createResponseBuilder($view);
		return array($topic, $response);
	}

	/**
	 *
	 * @param Request $request The request.
	 * @param TopicInterface $topic The topic.
	 */
	public function viewAction(Request $request, TopicInterface $topic, $pageSize = 10)
	{
		/** @var $paginator \Knp\Components\Pager\Paginator */
		$paginator = $this->get('knp_paginator');

		$page = $request->query->get('page', 1);
		$posts = $this->postManager->findAllByTopic($topic);
		$paginatedPosts = $paginator->paginate($posts, $page, $pageSize);

		$view = View::create(array('topic' => $topic, 'page' => $page, 'posts' => $paginatedPosts))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('LorecallChronicleBundle:Topic:view.html.twig');
		$response = $this->createResponseBuilder($view);
		return array($topic, $response);
	}
}
