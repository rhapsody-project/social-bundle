<?php
/* Copyright (c) 2013 Rhapsody Project
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
 * Activities can represent different types of content, to simplify the
 * assignment of content to an activity (and the lookup of activities with
 * different types of content) all activities have a <tt>$content</tt> property
 * which can receive the content. This effectively makes the activity a wrapper
 * around different types of actionable content.
 *
 * @author Sean.Quinn
 * @since 1.0
 */
class Activity implements ActivityInterface
{

	/**
	 * The ID of this activity.
	 * @var mixed
	 */
	protected $id;

	/**
	 * The user who posted this activity.
	 * @var mixed
	 * @access protected
	 */
	protected $author;

	/**
	 * A colleciton of <code>Rhapsody\SocialBundle\Model\CommentInterface</code>
	 * objects.
	 * @var array
	 * @access protected
	 */
	protected $comments = array();

	/**
	 * The content that this activity encapsulates, may be a blog post, image,
	 * website link, or any other type of content. May be <tt>null</tt>.
	 * @var mixed
	 * @access protected
	 */
	protected $content;

	/**
	 * The date that this activity was posted.
	 * @var \DateTime
	 * @access protected
	 */
	protected $date;

	/**
	 * Colleciton of endorsements, e.g. likes, that this activity has received.
	 * @var array
	 * @access protected
	 */
	protected $endorsements = array();

	/**
	 * The source of this activity.
	 * @var mixed
	 * @access protected
	 */
	protected $source;

	/**
	 * The text content of the activity.
	 * @var string
	 * @access protected
	 */
	protected $text;

	/**
	 * The type of the activity.
	 * @var string
	 * @access protected
	 */
	protected $type;

	public function __construct()
	{
		$this->date = new \DateTime;
	}

	public function __toString()
	{
		$class = get_class($this);
		return $class.'@'.spl_object_hash($this);
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function getComments()
	{
		return $this->comments;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getEndorsements()
	{
		return $this->endorsements;
	}

	public function getSource()
	{
		return $this->source;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getText()
	{
		return $this->text;
	}

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

	public function setAuthor($author)
	{
		$this->author = $author;
	}

	public function setComments($comments)
	{
		$this->comments = $comments;
	}

	/**
	 *
	 * @param mixed $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function setEndorsements($endorsements)
	{
		$this->endorsements = $endorsements;
	}

	/**
	 *
	 * @param ActivitySourceInterface $source
	 */
	public function setSource($source)
	{
		$this->source = $source;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function setType($type)
	{
		$this->type;
	}

	public function setUser($user)
	{
		$this->user = $user;
	}
}
