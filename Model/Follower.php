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
 * A contract that describes a follower.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class Follower implements FollowerInterface
{

    /**
     * The follower's ID.
     * @var mixed
     */
    protected $id;

    /**
     * The date that a user established themself as a follower for a followable
     * record.
     * @var \DateTime
     */
    protected $created;

    /**
     * The record that a user is following.
     * @var FollowableInterface
     */
    protected $following;

    /**
     * The date that follower entry was last modified.
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * The user following a followable record.
     * @var UserInterface
     */
    protected $user;

    public function __construct()
    {
        $this->created = new \DateTime;
        $this->lastModified = new \DateTime;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\FollowerInterface::getCreated()
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\FollowerInterface::getFollowing()
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\FollowerInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\FollowerInterface::getLastModified()
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\FollowerInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the date this follower was created.
     *
     * @param \DateTime $created the date that a follower was created.
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * Set the record that is being followed.
     *
     * @param FollowableInterface $following the record being followed.
     */
    public function setFollowing(FollowableInterface $following)
    {
        $this->following = $following;
    }

    /**
     * Set the follower's ID.
     *
     * @param mixed $id the follower's ID.
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Set the date this follower record was last modified.
     *
     * @param \DateTime $lastModified the date the record was last modified.
     */
    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * Set the user.
     *
     * @param UserInterface $user the user.
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }
}