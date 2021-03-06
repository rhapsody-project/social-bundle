<?php
/* Copyright (c) 2015 Rhapsody Project
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

/**
 * An implementation of the PostInterface.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Post implements PostInterface, AuthorAwareInterface, ShareableInterface, SocialContextAwareInterface, EndorsementAwareInterface, TopicAwareInterface
{

	/**
	 * The identifier for the post.
	 * @var mixed
	 * @access protected
	 */
	protected $id;

	/**
	 * Whether the post has been approved or not. When initialized a post will
	 * have its approval flag set to <tt>true</tt>, for certain social
	 * interaction models that require moderator approval before being visible
	 * the post must have its <tt>$approved</tt> flag set to <tt>false</tt>
	 * explicitly.
	 *
	 * @var boolean
	 * @access protected
	 */
	protected $approved;

	/**
	 * The files that have been attached to this post.
	 * @var array
	 * @access protected
	 */
	protected $attachments;

	/**
	 * The author of the post.
	 * @var mixed
	 * @access protected
	 */
	protected $author;

	/**
	 * The date and time that this post was created.
	 * @var \DateTime
	 * @access protected
	 */
	protected $created;

	/**
	 * The number of times that the post has been edited.
	 * @var int
	 * @access protected
	 */
	protected $editCount;

	/**
	 * Colleciton of endorsements, e.g. likes, that this activity has received.
	 * @var array
	 * @access protected
	 */
	protected $endorsements = array();

	/**
	 * The numerical index of the post, relative to its topic.
	 * @var int
	 * @access protected
	 */
	protected $index;

	/**
	 * The date and time that this post was last updated. Equal to the
	 * <tt>$created</tt> date if the post has never been edited.
	 * @var \DateTime
	 * @access protected
	 */
	protected $lastUpdated;

	/**
	 * The number of times that this post has been liked.
	 * @var int
	 * @access protected
	 */
	protected $likes = 0;

	/**
	 * If a this is a reply to a preceding post, <tt>$replyTo</tt> is the
	 * reference to that <tt>Post</tt>.
	 * @var Post
	 * @access protected
	 */
	protected $replyTo;

	/**
	 * The revision history of the post.
	 * @var array
	 * @access protected
	 */
	protected $revisions = array();

	/**
	 * Tracks the score of the post; this roughly translates into how many people
	 * have "liked" the post.
	 * @var int
	 * @access protected
	 */
	protected $score;

	/**
	 * The slug for the post.
	 * @var string
	 */
	protected $slug;

	/**
	 * The social context of the post, e.g. forum, wall, blog, etc.
	 * @var SocialContextInterface
	 * @access protected
	 */
	protected $socialContext;

	/**
	 * The subject of this post.
	 * @var string
	 * @access protected
	 */
	protected $subject;

	/**
	 * The text of this post.
	 * @var string
	 * @access protected
	 */
	protected $text;

	/**
	 * The topic that this post belongs to.
	 * @var TopicInterface
	 * @access protected
	 */
	protected $topic;

	public function __construct()
	{
		$this->approved = true;
		$this->created = new \DateTime();
		$this->lastUpdated = new \DateTime();
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getAttachments()
	 */
	public function getAttachments()
	{
		return $this->attachements;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\AuthorAwareInterface::getAuthor()
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getCreated()
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getEditCount()
	 */
	public function getEditCount()
	{
		return $this->editCount;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\EndorsementAwareInterface::getSocialContext()
	 */
	public function getEndorsements()
	{
		return $this->endorsements;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\SocialContextAwareInterface::getSocialContext()
	 */
	public function getSocialContext()
	{
		return $this->socialContext;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getCreated()
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getIndex()
	 */
	public function getIndex()
	{
		return $this->index;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getLastUpdated()
	 */
	public function getLastUpdated()
	{
		return $this->lastUpdated;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getRevisions()
	 */
	public function getRevisions()
	{
		return $this->revisions;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getSubject()
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::getText()
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\TopicAwareInterface::getTopic()
	 */
	public function getTopic()
	{
		return $this->topic;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::isApproved()
	 */
	public function isApproved()
	{
		return $this->approved;
	}

	/**
	 * Sets the flag indicating that the post has been approved.
	 *
	 * @param boolean $approved the approval flag.
	 */
	public function setApproved($approved)
	{
		$this->approved = $approved;
	}

	/**
	 * Sets the collection of attachments on the post.
	 *
	 * @param mixed $attachements the attachments.
	 */
	public function setAttachments($attachements)
	{
		$this->attachements = $attachements;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\AuthorAwareInterface::setAuthor()
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::setCreated()
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * Sets the number of times that this post has been edited.
	 * @param int $editCount the edit count.
	 */
	public function setEditCount($editCount)
	{
		$this->editCount = $editCount;
	}

	/**
	 * Sets the social context that this post belongs to.
	 * @param SocialContextInterface $socialContext the social context.
	 */
	public function setSocialContext($socialContext)
	{
		$this->socialContext = $socialContext;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::setCreated()
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::setIndex()
	 */
	public function setIndex($index)
	{
		$this->index = $index;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::setLastUpdated()
	 */
	public function setLastUpdated($lastUpdated)
	{
		$this->lastUpdated = $lastUpdated;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::setRevisions()
	 */
	public function setRevisions($revisions)
	{
		$this->revisions = $revisions;
	}

	public function setSlug($slug)
	{
		$this->slug = $slug;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::setSubject()
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Model\PostInterface::setText()
	 */
	public function setText($text)
	{
		$this->text = $text;
	}

	/**
	 * Sets the topic for this post.
	 * @param TopicInterface $topic the topic.
	 */
	public function setTopic($topic)
	{
		$this->topic = $topic;
	}
}
