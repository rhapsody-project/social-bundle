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
 * Marks an object as one that can be endorsed.
 *
 * If an object implements the <code>EndorsableInterface</code> it means that
 * the object can be endorsed. If endorsed, a new <code>Endorsement</code>
 * record should be created that reflects what was endorsed, when, and by whom.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface EndorsementInterface
{

    /**
     * Return the date of the endorsement.
     *
     * @return \DateTime the date of the endorsement.
     */
    function getDate();

    /**
     * Return the object being endorsed.
     *
     * @return EndorsableInterface the object being endorsed.
     */
    function getEndorsed();

    /**
     * Return the endorsement's ID.
     *
     * @return mixed the endorsement's ID.
     */
    function getId();

    /**
     * Return the user responsible for the endorsement.
     *
     * @return UserInterface the user responsible for the endorsement.
     */
    function getUser();

}