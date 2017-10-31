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
namespace Rhapsody\SocialBundle\Repository;

use Rhapsody\SocialBundle\Model\AffiliationInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Repository
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface AffiliationRepositoryInterface
{

    /**
     * Find affiliations by the affiliated user.
     *
     * @param mixed $user An object implementing the <code>UserInterface</code>
     *     or the user's ID.
     * @param number $limit The limit to apply to the number of results returned
     *     at a time.
     * @param number $offset The offset to start the results at.
     * @return array the affiliations by the affiliated user.
     */
    function findByAffiliation($user, $limit = null, $offset = 0);

    /**
     * Find affiliations by user.
     *
     * @param mixed $user An object implementing the <code>UserInterface</code>
     *     or the user's ID.
     * @param number $limit The limit to apply to the number of results returned
     *     at a time.
     * @param number $offset The offset to start the results at.
     * @return array the affiliations for a user.
     */
    function findByUser($user, $limit = null, $offset = 0);

    /**
     * Find an affiliation by its ID.
     *
     * @param mixed $id
     * @return AffiliationInterface the affiliation that corresponds to the ID
     *     passed, or <code>null</code>.
     */
    function findOneById($id);
}
