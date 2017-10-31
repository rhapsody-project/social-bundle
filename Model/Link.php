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
 * A <code>Link</code> is a type of content that is independent of any social
 * context.
 *
 * @author    Sean Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class Link extends Content implements LinkInterface
{
    /**
     * The ID of this link.
     * @var mixed
     */
    protected $id;

    /**
     * The URL to the content being represented by this link.
     * @var string
     */
    protected $url;

    /**
     * Collection of preview images. If empty, no images are attached to the
     * URL content. If there is more than one image, it is up to the client
     * to decide how to represent them. Not all clients will support showing
     * more than one preview image.
     * @var array
     */
    protected $previewImages = array();

    /**
     * Summary text, usually taken from the description of the URL.
     * @var string
     */
    protected $summary;

    /**
     * The type of the link; taxonomy that can be used to distinguish between
     * links to external content (e.g. Facebook posts, tweets on Twitter, etc.)
     * or media (e.g. videos, images, etc.).
     * @var string
     */
    protected $type;

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\LinkInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\LinkInterface::getPreviewImages()
     */
    public function getPreviewImages()
    {
        return $this->previewImages;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\LinkInterface::getSummary()
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\LinkInterface::getType()
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\LinkInterface::getUrl()
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the link's ID.
     *
     * @param mixed $id the link's ID.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the preview images for the link.
     *
     * @param array $previewImages the preview images for the link.
     */
    public function setPreviewImages(array $previewImages = array())
    {
        $this->previewImages = $previewImages;
    }

    /**
     * Set the link's summary.
     *
     * @param string $summary the summary.
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * Set the link's type.
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Set the link's URL
     *
     * @param strin $url the URL.
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}