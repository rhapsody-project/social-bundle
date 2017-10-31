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
namespace Rhapsody\SocialBundle\Mailer;

use Symfony\Component\Security\Core\User\UserInterface;
/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Mailer
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class MailUser implements UserInterface
{

	/**
	 * The email address of the mail user.
	 * @var string
	 */
	private $email;

	/**
	 * The username of the mail user.
	 * @var string
	 */
	private $username;

	public function __construct($username, $email)
	{
		$this->username = $username;
		$this->email = $email;
	}

	/**
	 * Returns the email address of the mail user.
	 * @return string the email address of the user.
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
	 */
	public function getRoles()
	{
		trigger_error('The MailUser is a non-persistent user class; UserInterface::getRoles() is not supported.', E_WARNING);
		return array();
	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getPassword()
	 */
	public function getPassword()
	{
		trigger_error('The MailUser is a non-persistent user class; UserInterface::getPassword() is not supported.', E_WARNING);
		return null;
	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getSalt()
	 */
	public function getSalt()
	{
		trigger_error('The MailUser is a non-persistent user class; UserInterface::getSalt() is not supported.', E_WARNING);
		return null;
	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getUsername()
	 */
	public function getUsername()
	{
		return $this->username;
	}


	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
	 */
	public function eraseCredentials()
	{
		trigger_error('The MailUser is a non-persistent user class; UserInterface::eraseCredentials() is not supported.', E_WARNING);
	}
}