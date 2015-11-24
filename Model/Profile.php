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
namespace Rhapsody\SocialBundle\Model;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Profile
{
	/**
	 * The object ID of the character.
	 * @var mixed
	 * @access protected
	 */
	protected $id;

	/**
	 * An array of activity sources that a user is following.
	 * @var array $following
	 */
	protected $following;

	/**
	 * The user associated with this profile.
	 * @var mixed
	 */
	protected $user;

	public function __construct()
	{
		$this->following = array();
	}

	public function follow(ActivitySourceInterface $subject)
	{
		if (!$this->isFollowing($subject)) {
			array_push($this->following, $subject);
		}
	}

	/**
	 * Returns a collection of activity sources that a user is following.
	 *
	 * @return array a collection of activity sources that a user is following.
	 */
	public function getFollowing()
	{
		return $this->following;
	}

	/**
	 * Returns the primary identifier of the user profile.
	 *
	 * @return mixed the user profile's primary identifier.
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Returns the user who is associated with this profile.
	 *
	 * @return mixed the user who is associated with this profile.
	 */
	public function getUser()
	{
		return $this->user;
	}

	public function isFollowing(ActivitySourceInterface $subject)
	{
		foreach ($this->following as $followed) {
			if (get_class($subject) === get_class($followed)
					&& $subject->id === $followed->id) {
				return true;
			}
		}
		return false;
	}

	/**
	 *
	 * @param unknown $id
	 */
	public function setFollowing($following)
	{
		$this->following = $following;
	}

	/**
	 *
	 * @param unknown $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Sets the user associated with this profile.
	 * @param mixed $user the user.
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}

}