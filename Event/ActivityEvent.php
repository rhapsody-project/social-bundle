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
namespace Rhapsody\SocialBundle\Event;

use Rhapsody\SocialBundle\Model\ActivitySourceInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Event
 * @copyright Copyright (c) 2015 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityEvent extends Event implements ActivityEventInterface
{

	/**
	 * The object of activity. May be <tt>null</tt>.
	 * @var mixed
	 */
	private $object;

	/**
	 * The activity source; an activity source where an activity came from,
	 * e.g. forum, blog, etc.
	 * @var \Rhapsody\SocialBundle\Model\ActivitySourceInterface
	 */
	private $source;

	/**
	 * The user respobsible for generating the activity.
	 * @var \Symfony\Component\Security\Core\User\UserInterface\UserInterface
	 */
	private $user;

	public function __construct()
	{
		// Empty
	}

	public function getObject()
	{
		return $this->object;
	}

	public function getSource()
	{
		return $this->source;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function setObject($object)
	{
		$this->object = $object;
	}

	public function setSource(ActivitySourceInterface $source)
	{
		$this->source = $source;
	}

	public function setUser(UserInterface $user)
	{
		$this->user = $user;
	}
}
