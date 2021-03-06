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
namespace Rhapsody\SocialBundle\Controller\Delegate;

use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Rhapsody\RestBundle\HttpFoundation\Controller\Delegate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Controller\Delegate
 * @copyright Copyright (c) 2015 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityDelegate extends Delegate
{

	/**
	 *
	 * @param Request $request
	 * @param UserInterface $user
	 * @param unknown $date
	 * @param number $limit
	 * @return \Rhapsody\ComponentExtensionBundle\HttpFoundation\Controller\ResponseBuilderInterface
	 */
	public function listAction(Request $request, UserInterface $user, $date = null, $limit = 50)
	{
		/** @var $activityManager \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface */
		$activityManager = $this->get('rhapsody.social.doctrine.activity_manager');

		/** @var $profileManager \Rhapsody\SocialBundle\Doctrine\ProfileManagerInterface */
		$profileManager = $this->get('rhapsody.social.doctrine.profile_manager');

		$sources = $profileManager->findSourcesFollowedByUser($user);
		$activities = $activityManager->findActivityBySource($sources, $date, $limit);
		$view = View::create()
			->setData(array('activities' => $activities))
			->setFormat($request->getRequestFormat('html'))
			->setSerializationContext(SerializationContext::create()->setGroups('context'))
			->setTemplate('RhapsodySocialBundle:Activity:list.html.twig');
		return $this->createResponseBuilder($view);
	}
}