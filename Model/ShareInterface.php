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
 * A contract representing an activity, or other shareable, object's shares.
 *
 * We can track the number of times a shareable has been shared, by whom and
 * by date, through the collection of shares that reference the shareable.
 *
 * @author Sean.Quinn
 */
interface ShareInterface
{

    /**
     * Return the date of the share.
     *
     * @return \DateTime the date of the share.
     */
    function getDate();

    /**
     * Return the share's ID.
     *
     * @return mixed the share's ID.
     */
    function getId();

    /**
     * Return the object being shared.
     *
     * @return ShareableInterface the object being shared.
     */
    function getShared();

    /**
     * Return the user responsible for the sharing.
     *
     * @return UserInterface the user responsible for the sharing.
     */
    function getUser();

}