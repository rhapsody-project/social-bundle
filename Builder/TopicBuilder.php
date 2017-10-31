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
class TopicBuilder
{

	/**
	 * The authorization checker.
	 * @var AuthorizationCheckerInterface $authorizationChecker
	 */
	protected $authorizationChecker;

	/**
	 */
	protected $class;
	protected $object;
	protected $validator;

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

	public function setCategory($category)
	{
		$this->object->setCategory($category);
		return $this;
	}

	public function setCreated($created)
	{
		$this->object->setCreated($created);
		return $this;
	}

	public function setSocialContext(SocialContextInterface $socialContext)
	{
		$this->object->setSocialContext($socialContext);
		return $this;
	}

	public function setLastUpdated($lastUpdated)
	{
		$this->object->setLastUpdated($lastUpdated);
		return $this;
	}

	public function setLocked($locked)
	{
		$this->object->setLocked($locked);
		return $this;
	}

	public function setPoll($poll)
	{
		$this->object->setPoll($poll);
		return $this;
	}

	public function setPosts($posts)
	{
		$this->object->setPosts($posts);
		return $this;
	}

	public function setPromotionDays($promotionDays)
	{
		$this->object->setPromotionDays($promotionDays);
		return $this;
	}

	public function setSubject($subject)
	{
		$this->object->setSubject($subject);
		return $this;
	}

	public function setType($type)
	{
		$this->object->setType($type);
		return $this;
	}
}
