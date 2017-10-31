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
 * A contract representing a request for affiliation.
 *
 * Unlike following, which doesn't require consent from another user in a
 * system, an affiliation requires that two users agree to become affiliated
 * with one another. Affiliations are a bi-directional association between
 * two users. Affiliations are created after an affiliation request is
 * approved by the target (receiving) user.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface AffiliationRequestInterface
{

    /**
     * Return the date that this request was accepted.
     *
     * @return \DateTime the date that this request was accepted.
     */
    function getAcceptedOn();

    /**
     * Return the date that this request was created.
     *
     * @return \DateTime the date that this request was created.
     */
    function getCreated();

    /**
     * Return the date that this request expires.
     *
     * @return \DateTime the date that this request expires.
     */
    function getExpiresAt();

    /**
     * Return the ID of this affiliation request.
     *
     * @return mixed the ID of this affiliation request.
     */
    function getId();

    /**
     * Return the recipeint of the affiliation request.
     *
     * The recipient is the user who must approve the affiliation request in
     * order to establish the affiliation.
     *
     * @return UserInterface the recipient of the affiliation request.
     */
    function getRecipient();

    /**
     * Return the user who made the request.
     *
     * @return UserInterface the user that made the request.
     */
    function getRequestedBy();

    /**
     * Return whether or not the affiliation request has been accepted.
     *
     * @return bool <code>true</code> if the affiliation request has been
     *     accepted; otherwise <code>false</code>.
     */
    function isAccepted();

    /**
     * Return whether or not the affiliation request has expired.
     *
     * @return bool <code>true</code> if the affiliation request has expired;
     *     otherwise <code>false</code>.
     */
    function isExpired();

}