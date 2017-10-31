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
namespace Rhapsody\SocialBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author    Sean W. Quinn <sean.quinn@extesla.com>
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Reputation implements ReputationInterface
{

	/**
	 * The value of a <tt>$user</tt>'s reputation.
	 * @var int
	 */
	protected $value = 0;

	/**
	 * The total earned reputation is a measure of how much reputation a user
	 * has earned over their lifetime.
	 * @var int
	 */
	protected $totalEarnedKarma = 0;

	/**
	 * The user whose reputation this is.
	 * @var \Symfony\Component\Security\Core\User\UserInterface
	 */
	protected $user;

	public function __construct()
	{
		// Empty.
	}

	/**
	 * {@inheritDoc}
	 * @see \Rhapsody\SocialBundle\Model\ReputationInterface::getUser()
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * {@inheritDoc}
	 * @see \Rhapsody\SocialBundle\Model\ReputationInterface::getValue()
	 */
	public function getValue()
	{
		return $this->value;
	}

	public function setUser(UserInterface $user)
	{
		$this->user = $user;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}
}