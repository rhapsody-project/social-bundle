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

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface SocialContextInterface
{

	/**
	 * Return the date that the social context was created.
	 *
	 * @return \DateTime the date when the social context was created.
	 */
	function getCreated();

	/**
	 * Return the object ID of the social context.
	 *
	 * @return mixed the object ID of the social context.
	 */
	function getId();

	/**
	 * Return the date when the social context was last indexed.
	 *
	 * @return \DateTime the date when the social context was last indexed.
	 */
	function getLastIndexed();

	/**
	 * Return the date when the social context was last modified.
	 *
	 * @return \DateTime the date when the social context was last modified.
	 */
	function getLastModified();

	/**
	 * Return whether or not the social context is enabled.
	 *
	 * @return boolean <code>true</code> if the social context is enabled;
	 *     otherwise <code>false</code>.
	 */
	function isEnabled();

}
