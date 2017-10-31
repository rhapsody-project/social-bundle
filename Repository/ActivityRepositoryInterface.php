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

use Rhapsody\SocialBundle\Model\ActivityInterface;
use Rhapsody\SocialBundle\Model\ActivitySourceInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Repository
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface ActivityRepositoryInterface
{

    /**
     * Find activity by a common activity source.
     *
     * @param mixed $activitySource The activity source, or the ID of an
     *     activity source.
     * @param number $limit The number of records to limit the results to.
     * @param number $offset The offset indicating which record to begin
     *     returning results from.
     */
    function findByActivitySource(ActivitySourceInterface $activitySource, $limit = null, $offset = 0);

    /**
     * Find activity by user in the specified date range.
     *
     * @param mixed $user An object implementing the <code>UserInterface</code>
     *     or the user's ID.
     * @param \DateTime $start The start of the date range.
     * @param \DateTime $end The end of the date range.
     * @param number $limit The limit to apply to the number of results returned
     *     at a time.
     * @param number $offset The offset to start the results at.
     * @return array the activity for a user in a date range.
     */
    function findByUserAndDate($user, \DateTime $start, \DateTime $end, $limit = null, $offset = 0);

    /**
     * Find activity by user.
     *
     * @param mixed $user An object implementing the <code>UserInterface</code>
     *     or the user's ID.
     * @param number $limit The limit to apply to the number of results returned
     *     at a time.
     * @param number $offset The offset to start the results at.
     * @return array the activity for a user.
     */
    function findByUser($user, $limit = null, $offset = 0);

    /**
     * Find an activity by its ID.
     *
     * @param mixed $id
     * @return ActivityInterface the activity that corresponds to the ID passed,
     *     or <code>null</code> if no activity matches the given ID.
     */
    function findOneById($id);
}
