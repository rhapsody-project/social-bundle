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
namespace Rhapsody\SocialBundle\Model;

/**
 *
 * @author Sean.Quinn
 */
class Comment implements CommentInterface
{

	/**
	 * The date that this activity was posted.
	 * @var \DateTime
	 * @access protected
	 */
	protected $date;

	/**
	 * Colleciton of endorsements, e.g. likes, that this activity has received.
	 * @var array
	 * @access protected
	 */
	protected $endorsements = array();

	/**
	 * The text content of the activity.
	 * @var string
	 * @access protected
	 */
	protected $text;

	/**
	 * The user whom this activity is associated with.
	 * @var mixed
	 * @access protected
	 */
	protected $user;

	public function __construct()
	{
		$this->date = new \DateTime;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getEndorsements()
	{
		return $this->endorsements;
	}

	public function getText()
	{
		return $this->text;
	}

	/**
	 *
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->user;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function setEndorsements($endorsements)
	{
		$this->endorsements = $endorsements;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}
}
