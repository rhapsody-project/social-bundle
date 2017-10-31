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
use Rhapsody\RestBundle\Factory\ContextFactory;
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Controller\Delegate
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityDelegate extends Delegate
{

    /**
     *
     * @param Request $request
     * @param string $activityId
     * @return \Rhapsody\ComponentExtensionBundle\HttpFoundation\Controller\ResponseBuilderInterface
     *     The response builder.
     */
    public function getAction(Request $request, $activityId)
    {
        /** @var $activityManager \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface */
        $activityManager = $this->get('rhapsody.social.doctrine.activity_manager');

        $activity = $activityManager->findActivityById($activityId);
        $view = View::create()
            ->setData(array('socialActivity' => $activity))
            ->setFormat($this->getFormat('html'))
            ->setTemplate('RhapsodySocialBundle:Activity:view.html.twig');
        return $this->createResponseBuilder($view);
    }

    /**
     * Returns a response containing a collection of a <code>$user</code>'s
     * activities.
     *
     * @param Request $request
     * @param UserInterface $user
     * @param unknown $date
     * @param number $limit
     * @return \Rhapsody\ComponentExtensionBundle\HttpFoundation\Controller\ResponseBuilderInterface
     */
    public function listActivityForUserAction(Request $request, UserInterface $user, $date = null, $limit = 50)
    {
        /** @var $activityManager \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface */
        $activityManager = $this->get('rhapsody.social.doctrine.activity_manager');

        /** @var $profileManager \Rhapsody\SocialBundle\Doctrine\ProfileManagerInterface */
        $profileManager = $this->get('rhapsody.social.doctrine.profile_manager');

        $sources = $profileManager->findSourcesFollowedByUser($user);
        $activities = $activityManager->findActivityBySource($sources, $date, $limit);

        $view = View::create()
            ->setData(array('socialActivities' => $activities))
            ->setFormat($this->getFormat('html'))
            ->setContext(ContextFactory::create(array('list')))
            ->setTemplate('RhapsodySocialBundle:Activity:list.html.twig');
        return $this->createResponseBuilder($view);
    }

    public function newAction(Request $request, UserInterface $user)
    {
        /** @var $activityManager \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface */
        $activityManager = $this->get('rhapsody.social.doctrine.activity_manager');

        /** @var $formFactory \Rhapsody\SocialBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('rhapsody_social.activity.form.factory');

        /** @var $category \Rhapsody\SocialBundle\Model\TopicInterface */
        $activity = $activityManager->newActivity($user);
        $form = $formFactory->createForm();
        $form->setData($activity);

        $view = View::create(array('form' => $form->createView()))
            ->setFormat($this->getFormat('html'))
            ->setContext(ContextFactory::create(array('all')))
            ->setTemplate('RhapsodySocialBundle:Activity:new.html.twig');
        return $this->createResponseBuilder($view);
    }
}