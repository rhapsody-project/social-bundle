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
abstract class Comment implements CommentInterface, EndorsableInterface
{

    /**
     * The object identifier.
     * @var number
     */
    protected $id;

    /**
     * The date that this comment was posted.
     * @var \DateTime
     */
    protected $created;

    /**
     * The number of endorsements that this comment has.
     * @var int
     */
    protected $endorsementCount = 0;

    /**
     * The owner of this comment.
     * @var CommentableInterface
     */
    protected $parent;

    /**
     * The text of the comment.
     * @var string
     */
    protected $text;

    /**
     * The user who posted this comment.
     * @var UserInterface
     */
    protected $user;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\CommentInterface::getCreated()
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\CommentInterface::getEndorsementCount()
     */
    public function getEndorsementCount()
    {
        return $this->endorsementCount;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\CommentInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\CommentInterface::getText()
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\CommentInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the created date of the comment.
     *
     * @param \DateTime $date the date the comment was created.
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * Set the endorsement count of the comment.
     *
     * @param int $endorsementCount count of endorsements.
     */
    public function setEndorsementCount($endorsementCount)
    {
        $this->endorsementCount = $endorsementCount;
    }

    /**
     * Set the object ID of the comment.
     *
     * @param mixed $id the comment's ID.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setParent(CommentableInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Set the text of the comment.
     *
     * @param string $text the comment's text.
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Set the user who authored and owns the comment.
     *
     * @param UserInterface $user the user who authored the comment.
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }
}
