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
namespace Rhapsody\SocialBundle\Controller;

use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Rhapsody\SocialBundle\Doctrine\ActivityManager;
use Rhapsody\SocialBundle\Document\Activity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author Sean.Quinn
 * @since 1.0
 */
class ActivityController extends Controller
{

	/**
	 * The feed index.
	 * This renders the current user's feed and is an alias to
	 * a user-specific feed.
	 *
	 * #url https://lorecall.com/activity
	 * #url https://lorecall.com/activity?filter={filter}
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function indexAction(Request $request)
	{
		/** @var $delegate \Rhapsody\SocialBundle\Controller\Delegate\ActivityDelegate */
		$delegate = $this->get('rhapsody.social.controller.delegate.activity_delegate');

		$user  = $this->getUser();
		$date  = $request->query->get('date', new \DateTime);
		$limit = $request->query->get('limit', 50);
		$response = $delegate->listAction($request, $user, $date, $limit);
		return $response->render();
	}

	/**
	 * Adds an activity to the database.
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 */
	public function addActivityAction(Request $request)
	{
		/** @var $postManager \Rhapsody\SocialBundle\Doctrine\ActivityManager */
		$activityManager = $this->get('rhapsody_social.activity_manager');

		$activity = new Activity();
		$form = $this->createForm(new ActivityForm());
		if ($request->isMethod('post')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$activity = $form->getData();
				$activityManager->updateActivity($activity);
			}
		}
	}

	/**
	 * Adds an activity to the database.
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 */
	public function createAction(Request $request)
	{
	}

	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 */
	public function deleteAction(Request $request)
	{
		$activityManager = $this->getActivityManager();

		$activity = $request->get('activity');
		$_activity = $activityManager->findOneBy(array('id' => $activity
		));
		$activityManager->deleteActivity($_activity);
	}

	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 */
	public function feedAction(Request $request)
	{
		/** @var $request \Symfony\Component\HttpFoundation\Request */
		$request = $this->getRequest();
		$activityManager = $this->getActivityManager();
	}

	/**
	 * Render the response for a specific user's feed.
	 *
	 * #url /social/users/{user}/activity/list
	 * #url /social/users/{user}/activity/list?filter={filter}
	 *
	 * @param Request The Request.
	 * @return Response the Response.
	 */
	public function listAction(Request $request)
	{
		/** @var $delegate \Rhapsody\SocialBundle\Controller\Delegate\ActivityDelegate */
		$delegate = $this->get('rhapsody.social.controller.delegate.activity_delegate');

		/** @var $userManager \Lorecall\UserBundle\Doctrine\UserManagerInterface */
		$userManager = $this->get('lorecall.user.doctrine.user_manager');

		$username = $request->query->get('username');
		$date = $request->query->get('date', new \DateTime);
		$limit = $request->query->get('limit', 50);

		$user = $userManager->findUserByUsername($username);
		if (empty($user)) {
			throw new \UnexpectedValueException('Unable to find user with username: '.$username);
		}

		$response = $delegate->listAction($request, $user, $date, $limit);
		return $response->render();
	}

	/**
	 * Adds an activity to the database.
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 */
	public function newAction(Request $request)
	{
		/** @var $activityManager \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface */
		$activityManager = $this->get('rhapsody.social.doctrine.activity_manager');

		/** @var $formFactory \Rhapsody\SocialBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->get('rhapsody_social.activity.form.factory');

		/** @var $user \Symfony\Component\Security\Core\User\UserInterface */
		$user = $this->getUser();

		/** @var $category \Rhapsody\SocialBundle\Model\TopicInterface */
		$activity = $activityManager->newActivity($user);
		$form = $formFactory->createForm();
		$form->setData($activity);

		$view = View::create(array('form' => $form->createView()
		))->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodySocialBundle:Activity:new.html.twig');
		return $this->get('fos_rest.view_handler')
			->handle($view);
	}

	/**
	 * @return \Rhapsody\SocialBundle\Doctrine\ActivityManager
	 */
	protected function getActivityManager()
	{
		$activityManager = $this->get('rhapsody_social.activity_manager');
		return $activityManager;
	}

	public function viewAction(Request $request)
	{
		$activityManager = $this->getActivityManager();
	}
}
