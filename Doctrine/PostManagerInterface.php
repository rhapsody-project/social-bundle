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
use Rhapsody\SocialBundle\Model\TopicInterface;
use Rhapsody\SocialBundle\Form\Factory\FactoryInterface;

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
interface PostManagerInterface
{

    /**
     *
     * @param TopicInterface $topic
     */
    function countPosts(TopicInterface $topic);

    /**
     *
     * @param TopicInterface $topic
     */
    function countReplies(TopicInterface $topic);

	function createPost(PostInterface $post, TopicInterface $topic, $user);

	/**
	 *
	 * @param TopicInterface $topic
	 */
	function findAllByTopic(TopicInterface $topic);

	/**
	 *
	 * @param TopicInterface $topic The topic to find recent posts in.
	 * @param number $limit The number of posts to return.
	 */
	function findRecentByTopic(TopicInterface $topic, $limit = 10);

	/**
	 *
	 * @param mixed $id The post's object ID.
	 */
	function findById($id);

	/**
	 *
	 * @param string $slug The post's slug.
	 */
	function findBySlug($slug);

	/**
	 *
	 * @param TopicInterface $topic
	 * @param unknown $limit
	 * @param number $offset
	 */
	function findByTopic(TopicInterface $topic, $limit = null, $offset = 0);

	/**
	 *
	 * @param TopicInterface $topic
	 * @param unknown $limit
	 * @param number $offset
	 */
	function findRepliesByTopic(TopicInterface $topic, $limit = null, $offset = 0);

	/**
	 * Return the registered form factory.
	 *
	 * @return FactoryInterface the form factory.
	 */
	function getFormFactory();

	function update(PostInterface $post, $andFlush = true);

}
