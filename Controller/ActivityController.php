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
namespace Rhapsody\SocialBundle\Controller;

use Rhapsody\SocialBundle\Doctrine\ActivityManager;
use Rhapsody\SocialBundle\Document\Activity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author    Sean.Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Controller
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityController extends Controller
{

    /**
     * The current user's activity feed.
     *
     * This is a convenient URL for returning the same data as calls made to
     * <code>/social/activity/{user}</code>.
     *
     * #url https://lorecall.com/activity
     * #url https://lorecall.com/activity?filter={filter}
     *
     * @param Request The Request.
     * @return Response the Response.
     */
    public function listAction(Request $request)
    {
        /** @var $delegate \Rhapsody\SocialBundle\Controller\Delegate\ActivityDelegate */
        $delegate = $this->get('rhapsody.social.controller.delegate.activity_delegate');

        $user  = $this->getUser();
        $date  = $request->query->get('date', new \DateTime);
        $limit = $request->query->get('limit', 50);
        $response = $delegate->listActivityForUserAction($request, $user, $date, $limit);
        return $response->render();
    }

    /**
     * Adds an activity to the database.
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function createAction(Request $request)
    {
        throw new \Exception('Not yet implemented');
    }

    /**
     * Adds an activity to the database.
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function commentAction(Request $request)
    {
        throw new \Exception('Not yet implemented');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function deleteAction(Request $request)
    {
        $activityManager = $this->getActivityManager();

        $activity = $request->get('activity');
        $_activity = $activityManager->findOneBy(array('id' => $activity));
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
     * Returns an activity, identified by the <code>activity</code> identifier
     * in the URL.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function getAction(Request $request)
    {
        /** @var $delegate \Rhapsody\SocialBundle\Controller\Delegate\ActivityDelegate */
        $delegate = $this->get('rhapsody.social.controller.delegate.activity_delegate');

        $response = $delegate->getAction($request, $request->get('activity'));
        return $response->render();
    }

    /**
     * Render the response for a specific user's feed.
     *
     * #url /social/activity/{user}
     * #url /social/activity/{user}?filter={filter}
     *
     * @param Request The Request.
     * @return Response the Response.
     */
    public function userAction(Request $request)
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

        $response = $delegate->listActivityForUserAction($request, $user, $date, $limit);
        return $response->render();
    }

    /**
     * Adds an activity to the database.
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function newAction(Request $request)
    {
        /** @var $delegate \Rhapsody\SocialBundle\Controller\Delegate\ActivityDelegate */
        $delegate = $this->get('rhapsody.social.controller.delegate.activity_delegate');

        /** @var $user \Symfony\Component\Security\Core\User\UserInterface */
        $user = $this->getUser();

        $response = $delegate->newAction($request, $user);
        return $response->render();
    }

    /**
     * @return \Rhapsody\SocialBundle\Doctrine\ActivityManager
     */
    protected function getActivityManager()
    {
        $activityManager = $this->get('rhapsody_social.activity_manager');
        return $activityManager;
    }

    /**
     * Adds or updates an activity.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function updateAction(Request $request)
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
}
