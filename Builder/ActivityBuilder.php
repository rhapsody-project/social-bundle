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
namespace Rhapsody\SocialBundle\Builder;

use Rhapsody\SocialBundle\Model\ActivitySourceInterface;
use Rhapsody\SocialBundle\Model\SocialContextInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Document
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityBuilder
{

	/**
	 * The authorization checker.
	 * @var AuthorizationCheckerInterface $authorizationChecker
	 * @access protected
	 */
	protected $authorizationChecker;

	/**
	 * The class to be instantiated by the builder.
	 * @var string
	 * @access protected
	 */
	protected $class;

	/**
	 * The object that is being built.
	 * @var mixed
	 * @access protected
	 */
	protected $object;

	/**
	 * The validator.
	 * @var ValidatorInterface
	 * @access protected
	 */
	protected $validator;

	/**
	 *
	 */
	public function __construct(AuthorizationCheckerInterface $authorizationChecker, $validator, $class)
	{
		$this->class = $class;
		$this->authorizationChecker = $authorizationChecker;
		$this->validator = $validator;

		$this->object = new $class();
	}

	public function build()
	{
		return $this->object;
	}

	/**
	 * Assigns an <tt>$author</tt> to the activity.
	 *
	 * @param mixed $author the author.
	 * @return ActivityBuilder this.
	 */
	public function setAuthor($author)
	{
		$this->object->setAuthor($author);
		return $this;
	}

	/**
	 * Assigns the content, <tt>$content</tt>, to the activity.
	 *
	 * @param mixed $content the content.
	 * @return ActivityBuilder this.
	 */
	public function setContent($content)
	{
		$this->object->setContent($content);
		return $this;
	}

	/**
	 * Assigns a date, <tt>$date</tt>, to the activity.
	 *
	 * Use this method to override the created date that is set in the
	 * activity's constructor.
	 *
	 * @param \DateTime $date the date.
	 * @return ActivityBuilder this.
	 */
	public function setDate(\DateTime $date)
	{
		$this->object->setDate($date);
		return $this;
	}

	/**
	 * Assigns an <tt>$source</tt> to the post.
	 *
	 * @param mixed $source the activity source.
	 * @return ActivityBuilder this.
	 */
	public function setSource(ActivitySourceInterface $source)
	{
		$this->object->setSource($source);
		return $this;
	}

	/**
	 * Assigns the <tt>$text</tt> to the activity.
	 *
	 * @param string $text the text.
	 * @return ActivityBuilder this.
	 */
	public function setText($text)
	{
		$this->object->setText($text);
		return $this;
	}

	/**
	 * Assigns the <tt>$user</tt> to the activity.
	 *
	 * @param mixed $user the text.
	 * @return ActivityBuilder this.
	 */
	public function setUser($user)
	{
		$this->object->setUser($user);
		return $this;
	}
}
