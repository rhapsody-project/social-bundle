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
 * The {@code PostInterface} represents the contract that all user-generated
 * social activity should inherit from.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Copyright (c) 2015 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface PostInterface
{

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getAttachments()
	 */
	function getAttachments();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getAuthor()
	 */
	function getAuthor();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getCreated()
	 */
	function getCreated();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getEditCount()
	 */
	function getEditCount();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getCreated()
	 */
	function getId();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getIndex()
	 */
	function getIndex();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getLastUpdated()
	 */
	function getLastUpdated();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getRevisions()
	 */
	function getRevisions();

	/**
	* (non-PHPDoc)
	* @see \Rhapsody\SocialBundle\Model\PostInterface::getSubject()
	*/
	function getSubject();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getText()
	 */
	function getText();

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getTopic()
	 */
	function getTopic();
}
