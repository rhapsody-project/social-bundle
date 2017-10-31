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
namespace Rhapsody\SocialBundle\Doctrine;

use Rhapsody\SocialBundle\Model\PostInterface;
use Rhapsody\SocialBundle\Model\SocialContextInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Doctrine
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
interface TopicManagerInterface
{

    /**
     *
     * @param SocialContextInterface $socialContext
     */
    function countTopics(SocialContextInterface $socialContext);

    function createTopic(TopicInterface $topic, PostInterface $post, $user);

    /**
     *
     * @param SocialContextInterface $socialContext
     */
    function findAll(SocialContextInterface $socialContext);

    /**
     *
     * @param SocialContextInterface $socialContext
     * @param mixed $category
     */
    function findAllByCategory(SocialContextInterface $socialContext, $category);

    /**
     *
     * @param SocialContextInterface $socialContext
     * @param number $limit
     * @param number $offset
     */
    function findBy(SocialContextInterface $socialContext, $limit = null, $offset = 0);

    /**
     *
     * @param mixed $id
     */
    function findById($id);

    /**
     *
     * @param string $slug
     */
    function findBySlug($slug);

    function getFormFactory();

    function markTopicAsViewed(TopicInterface $topic, UserInterface $user);

    function update(TopicInterface $forum, $andFlush = true);

    /**
     * Trigger an event upon viewing a topic.
     *
     * @param TopicInterface $topic the topic being viewed.
     * @param mixed $user the user viewing the event.
     * @param string $eventName the event name.
     */
    function viewTopic(TopicInterface $topic, $user, $eventName);
}
