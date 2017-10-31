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

use Doctrine\Common\Util\ClassUtils;

/**
 * An activity exposes content from a user or an actor within a system.
 *
 * Activities are the quintessential collection of user generated content. They
 * may (but are not required to) reference content.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Activity implements ActivityInterface, CommentableInterface, EndorsableInterface, ShareableInterface
{

    /**
     * The ID of this activity.
     * @var mixed
     */
    protected $id;

    /**
     * The comments associated with this Activity.
     * @var array
     */
    protected $comments = array();

    /**
     * Optional. The content that this activity encapsulates. Examples of
     * content are: blog posts, images, website links, videos, etc.
     *
     * A <code>null</code> value indicates that there is no content.
     * @var \Rhapsody\SocialBundle\Model\ContentInterface
     */
    protected $content;

    /**
     * The date that this activity was created.
     * @var \DateTime
     */
    protected $created;

    /**
     * The number of endorsements for this activity.
     * @var int
     */
    protected $endorsementCount = 0;

    /**
     * The date that this activity was last modified.
     * @var \DateTime
     */
    protected $lastModified;

    /**
     * The number of shares that this activity has.
     * @var integer
     */
    protected $shareCount = 0;

    /**
     * The source of this activity, e.g. user, group, or site-specific context.
     * @var mixed
     */
    protected $source;

    /**
     * The text content of the activity.
     * @var string
     */
    protected $text;

    /**
     * The type of the activity.
     * @var string
     */
    protected $type;

    /**
     * The user who posted this activity.
     * @var mixed
     */
    protected $user;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->lastModified = new \DateTime();

        $this->comments = array();
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\CommentableInterface::addComment()
     */
    public function addComment(CommentInterface $comment)
    {
        $comment->setParent($this);
        array_push($this->comments, $comment);
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\CommentableInterface::getComments()
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getContent()
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getContentType()
     */
    public function getContentType()
    {
        if (null !== $this->content) {
            return ClassUtils::getClass($this->content);
        }
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getCreated()
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getEndorsementCount()
     */
    public function getEndorsementCount()
    {
        return $this->endorsementCount;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getLastModified()
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getShareCount()
     */
    public function getShareCount()
    {
        return $this->shareCount;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getSource()
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getSourceType()
     */
    public function getSourceType()
    {
        if (null !== $this->source) {
            return ClassUtils::getClass($this->source);
        }
        return null;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getText()
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ActivityInterface::getType()
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the content of this activity.
     *
     * @param ContentInterface $content
     */
    public function setContent(ContentInterface $content)
    {
        $this->content = $content;
    }

    /**
     * Set the created date of this activity.
     *
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * Set the endorsement count of this activity.
     *
     * @param int $endorsementCount
     */
    public function setEndorsementCount($endorsementCount)
    {
        $this->endorsementCount = $endorsementCount;
    }

    /**
     * Set the ID of this activity.
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    public function setShareCount($shareCount)
    {
        $this->shareCount = $shareCount;
    }

    /**
     * @param ActivitySourceInterface $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}
