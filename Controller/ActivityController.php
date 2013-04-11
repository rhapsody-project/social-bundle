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

use Rhapsody\SocialBundle\Document\Activity;

use Rhapsody\SocialBundle\Doctrine\ActivityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 * @author Sean.Quinn
 * @since 1.0
 */
class ActivityController extends Controller
{

	/**
	 * Adds an activity to the database.
	 */
	public function addActivityAction()
	{
		/** @var $request \Symfony\Component\HttpFoundation\Request */
		$request = $this->getRequest();
		/** @var $postManager \Rhapsody\SocialBundle\Doctrine\ActivityManager */
		$activityManager = $this->get('rhapsody_social.activity_manager');

		$activity = new Activity();
		$form = $this->createForm(new ActivityForm());
		if ($request->isMethod('post')) {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$activity = $form->getData();
				$activityManager->updateActivity($activity);
			}
		}
	}

	public function deleteAction()
	{
		/** @var $request \Symfony\Component\HttpFoundation\Request */
		$request = $this->getRequest();
		$activityManager = $this->getActivityManager();

		$activity = $request->get('activity');
		$_activity = $activityManager->findOneBy(array('id' => $activity));
		$activityManager->deleteActivity($_activity);
	}

	/**
	 * @return \Rhapsody\SocialBundle\Doctrine\ActivityManager
	 */
	protected function getActivityManager()
	{
		$activityManager = $this->get('rhapsody_social.activity_manager');
		return $activityManager;
	}

	public function viewAction()
	{
		/** @var $request \Symfony\Component\HttpFoundation\Request */
		$request = $this->getRequest();
		$activityManager = $this->getActivityManager();


	}
}