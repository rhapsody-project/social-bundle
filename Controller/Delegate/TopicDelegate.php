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
namespace Rhapsody\SocialBundle\Controller\Delegate;

use FOS\RestBundle\View\View;
use Rhapsody\ComponentExtensionBundle\Exception\FormExceptionFactory;
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Rhapsody\SocialBundle\Doctrine\PostManagerInterface;
use Rhapsody\SocialBundle\Doctrine\TopicManagerInterface;
use Rhapsody\SocialBundle\Model\PostInterface;
use Rhapsody\SocialBundle\Model\SocialContextInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Rhapsody\RestBundle\Factory\ContextFactory;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Controller\Delegate
 * @copyright Copyright (c) Rhapsody Project
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
                ->setTemplate('RhapsodySocialBundle:Topic:new.html.twig');
            throw FormExceptionFactory::create('The form is invalid.')->setForm($form)->setView($view)->build();
        }

        $post = $form->get('post')->getData();
        $topic = $this->topicManager->createTopic($data, $post, $user);

        $this->container->get('session')->getFlashBag()->add('success', 'rhapsody.forum.topic.created');
        $view = View::createRouteRedirect('rhapsody_social_topic_view', array('topic' => $data->getId()))
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
     * Return a response containing the topic.
     *
     * @param Request $request
     * @return \Rhapsody\RestBundle\HttpFoundation\ViewResponseBuilder
     */
    public function getAction(Request $request)
    {
        $topic = $this->topicManager->findById($request->attributes->get('topic'));
        if (null === $topic) {
            throw $this->createNotFoundException(sprintf('Unable to find the topic: %s', $request->attributes->get('topic')));
        }

        $view = View::create()
            ->setData(array('topic' => $topic))
            ->setFormat($request->getRequestFormat('html'))
            ->setContext(ContextFactory::create(array('details')))
            ->setTemplate('RhapsodySocialBundle:Topic:get.html.twig');
        $response = $this->createResponseBuilder($view);
        return array($topic, $response);
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
    public function listAction(Request $request, SocialContextInterface $socialContext, $limit = null, $offset = 0)
    {
        $total = $this->topicManager->countTopics($socialContext);
        $topics = $this->topicManager->findBy($socialContext, $limit, $offset);

        $data = array('topics' => $topics);
        $metadata = array('total' => $total);
        $view = View::create()
            ->setData(array('data' => $data, 'meta' => $metadata))
            ->setFormat($request->getRequestFormat('html'))
            ->setTemplate('RhapsodySocialBundle:Topic:list.html.twig');
        $response = $this->createResponseBuilder($view);
        return array($topics, $metadata, $response);
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
            ->setTemplate('RhapsodySocialBundle:Topic:reply.html.twig');
        $response = $this->createResponseBuilder($view);
        return array($topic, $response);
    }

    /**
     * Return a response contain the topic and posts.
     *
     * @param Request $request The request.
     * @param TopicInterface $topic The topic.
     */
    public function viewAction(Request $request, TopicInterface $topic, $limit = null, $offset = 0)
    {
        $posts = $this->postManager->findByTopic($topic, $limit, $offset);

        $view = View::create()
            ->setData(array(
                'topic' => $topic,
                'posts' => $posts))
            ->setFormat($request->getRequestFormat('html'))
            ->setContext(ContextFactory::create(array('details')))
            ->setTemplate('RhapsodySocialBundle:Topic:view.html.twig');
        $response = $this->createResponseBuilder($view);
        return array($topic, $posts, $response);
    }
}
