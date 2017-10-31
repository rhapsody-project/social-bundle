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
class UserController extends Controller
{

    /**
     * Render the response for a specific user's feed.
     *
     * #url /social/activity/{user}
     * #url /social/activity/{user}?filter={filter}
     *
     * @param Request The Request.
     * @return Response the Response.
     */
    public function activityFeedAction(Request $request)
    {
        /** @var $delegate \Rhapsody\SocialBundle\Controller\Delegate\ActivityDelegate */
        $delegate = $this->get('rhapsody.social.controller.delegate.activity_delegate');

        /** @var $userManager \Lorecall\UserBundle\Doctrine\UserManagerInterface */
        $userManager = $this->get('lorecall.user.doctrine.user_manager');

        $username = $request->attributes->get('username');
        $date = $request->query->get('date', new \DateTime);
        $limit = $request->query->get('limit', 50);

        $user = $userManager->findUserByUsername($username);
        if (empty($user)) {
            throw new \UnexpectedValueException('Unable to find user with username: '.$username);
        }

        $response = $delegate->listActivityForUserAction($request, $user, $date, $limit);
        return $response->render();
    }

}
