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
abstract class SocialContext implements SocialContextInterface
{

    /**
     * The identifier for the forum.
     * @var mixed
     * @access protected
     */
    protected $id;

    /**
     * The date that the social context was created.
     * @var \DateTime
     * @access protected
     */
    protected $created;

    /**
     * Whether the social context is enabled or not.
     * @var boolean
     * @access protected
     */
    protected $enabled;

    /**
     * When the social context was last indexed.
     * @var \DateTime
     * @access protected
     */
    protected $lastIndexed;

    /**
     * When the social context was last indexed.
     * @var \DateTime
     * @access protected
     */
    protected $lastModified;

    /**
     * Constructor for the forum model.
     */
    public function __construct()
    {
        $this->created = new \DateTime;
        $this->lastModified = new \DateTime;
        $this->enabled = true;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\SocialContextInterface::getCreated()
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\SocialContextInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\SocialContextInterface::getLastIndexed()
     */
    public function getLastIndexed()
    {
        return $this->lastIndexed;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\SocialContextInterface::getLastModified()
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\SocialContextInterface::isEnabled()
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Sets the creation date of the social context.
     *
     * @param \DateTime $created the creation date.
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * Enables or disables the social context.
     *
     * @param boolean $enabled whether to enable or disable the social context.
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Sets the identifier of the social context.
     *
     * @param mixed $id the identifier.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Sets the date that the social context was last indexed.
     *
     * @param \DateTime $lastIndexed the last indexed date.
     */
    public function setLastIndexed(\DateTime $lastIndexed)
    {
        $this->lastIndexed = $lastIndexed;
    }

    /**
     * Sets the date that the social context was last modified.
     *
     * @param \DateTime $lastModified the last modified date.
     */
    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

}
