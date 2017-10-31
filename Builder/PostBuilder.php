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
class PostBuilder
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
	 * Assigns an <tt>$author</tt> to the post.
	 *
	 * @param mixed $author the author.
	 * @return PostBuilder this.
	 */
	public function setAuthor($author)
	{
		$this->object->setAuthor($author);
		return $this;
	}

	/**
	 * Assigns a created date, <tt>$created</tt>, to the post.
	 *
	 * Use this method to override the created date that is set in the post's
	 * constructor.
	 *
	 * @param \DateTime $created the created date.
	 * @return PostBuilder this.
	 */
	public function setCreated(\DateTime $created)
	{
		$this->object->setCreated($created);
		return $this;
	}

	/**
	 */
	public function setIndex($index)
	{
		$this->object->setIndex($index);
		return $this;
	}

	/**
	 * Assigns a last updated date, <tt>$lastUpdated</tt>, to the post.
	 *
	 * Use this method to override the last update date that is set in the post's
	 * constructor.
	 *
	 * @param \DateTime $lastUpdated the last updated date.
	 * @return PostBuilder this.
	 */
	public function setLastUpdated(\DateTime $lastUpdated)
	{
		$this->object->setLastUpdated($lastUpdated);
		return $this;
	}

	public function setSocialContext(SocialContextInterface $socialContext)
	{
		$this->object->setSocialContext($socialContext);
		return $this;
	}

	/**
	 * Assigns the <tt>$subject</tt> to the post.
	 *
	 * @param string $subject the subject.
	 * @return PostBuilder this.
	 */
	public function setSubject($subject)
	{
		$this->object->setSubject($subject);
		return $this;
	}

	/**
	 * Assigns the <tt>$text</tt> to the post.
	 *
	 * @param string $text the text.
	 * @return PostBuilder this.
	 */
	public function setText($text)
	{
		$this->object->setText($text);
		return $this;
	}

	/**
	 */
	public function setTopic($topic)
	{
		$this->object->setTopic($topic);
		return $this;
	}
}
