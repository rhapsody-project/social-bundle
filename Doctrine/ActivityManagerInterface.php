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
namespace Rhapsody\SocialBundle\Doctrine;

use Rhapsody\SocialBundle\Model\ActivityInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * A basic inplementation of the activity manager; this can be extended.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Doctrine
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface ActivityManagerInterface
{

	function findActivityBy(array $criteria = array());

	/**
	 * Return the activity for the given <code>$sources</code>. If a non-null
	 * date, <code>$date</code>, is supplied then all activity on that date and
	 * older will be returned up until the <code>$limit</code> (default: 50).
	 *
	 * @param array $sources the sources to return activity for.
	 * @param int $limit the maximum number of acitivities to return.
	 * @param \DateTime $date the date.
	 * @return array the collection of activity for the user.
	 */
	function findActivityBySource($sources = array(), $date = null, $limit = 50);

	function findAllActivityBy(array $criteria = array());

	/**
	 * Removes an activity from a user's activity feed. If an activity is
	 * removed that references another object, e.g. a blog post, that post will
	 * not be removed. In order to remove objects associated with an activity
	 * the user must appropriately manage that content elsewhere.
	 *
	 * @param ActivityInterface $activity
	 */
	function deleteActivity(ActivityInterface $activity);

	/**
	 *
	 * @param array $args arguments to build the new activity from.
	 * @param UserInterface $user
	 */
	function newActivity($args = array());

	function updateActivity(ActivityInterface $activity, $andFlush = true);
}
