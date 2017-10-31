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
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface ActivityInterface
{

    /**
     * Return the content associated with this activity.
     *
     * @return ContentInterface the content associated with this activity.
     */
    function getContent();

    /**
     * Return the type of the content, or <code>null</code>.
     *
     * @return string the type of the content, or <code>null</code>.
     */
    function getContentType();

    /**
     * Return the date that this activity was created.
     *
     * @return \DateTime the date that this activity was created.
     */
    function getCreated();

    /**
     * Return the number of endorsements that this activity has.
     *
     * @return int the number of endorsements that this activity has.
     */
    function getEndorsementCount();

    /**
     * Return the ID of this activity.
     *
     * @return mixed the ID of this activity.
     */
    function getId();

    /**
     * Return the date that this activity was last modified.
     *
     * @return \DateTime the date that this activity was last modified.
     */
    function getLastModified();

    /**
     * Return the number of shares that this activity has.
     *
     * @return int the number of shares that this activity has.
     */
    function getShareCount();

    /**
     * Returns the source of the activity.
     *
     * @return ActivitySourceInterface the source of the activity.
     */
    function getSource();

    /**
     * Return the type of the activity source, or <code>null</code>.
     *
     * @return string the type of the activity source, or <code>null</code>.
     */
    function getSourceType();

    /**
     * Return the text of this activity.
     *
     * @return string the text of this activity.
     */
    function getText();

    /**
     * Return the type of this activity.
     *
     * @return string the type of this activity.
     */
    function getType();

    /**
     * Return the user who generated this activity.
     *
     * @return UserInterface the user who generated this activity.
     */
    function getUser();
}