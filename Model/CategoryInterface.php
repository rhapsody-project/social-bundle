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
interface CategoryInterface
{
	/* The category is marked as a "private"" category. */
	const CATEGORY_PRIVACY_PRIVATE = 'social.category.privacy.private';

	/* The category is marked as a "public" category. */
	const CATEGORY_PRIVACY_PUBLIC = 'social.category.privacy.public';

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\ForumInterface::getCreated()
	 */
	function getCreated();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\ForumInterface::getDescription()
	 */
	function getDescription();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\ForumInterface::getId()
	 */
	function getId();

	/**
	 * Returns the last indexed date of the forum.
	 * @return \DateTime the last indexed date.
	 */
	function getLastIndexed();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\ForumInterface::getName()
	 */
	function getName();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\ForumInterface::getOrder()
	 */
	function getOrder();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\ForumInterface::getPrivacy()
	 */
	function getPrivacy();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\ForumInterface::getTags()
	 */
	function getTags();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\ForumInterface::getTopics()
	 */
	function getTopics();

}
