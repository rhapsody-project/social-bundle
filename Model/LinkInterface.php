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
 * @author sean.quinn
 *
 */
interface LinkInterface
{

    /**
     * Return the object ID of this link.
     *
     * @return mixed the object ID of this link.
     */
    function getId();

    /**
     * Return the collection of preview images.
     *
     * If the collection is empty, then there are now preview images associated
     * with this link.
     *
     * @return array the collection of preview images.
     */
    function getPreviewImages();

    /**
     * Return the summary text, describing the link.
     *
     * @return string the summary text which describes the link.
     */
    function getSummary();

    /**
     * Return the type of the link.
     *
     * A link type is a loose taxonomy that can be applied to links. It is most
     * often used for identifying the service from whence the linked content
     * originated, or the type of link (e.g. image, video, etc.).
     *
     * @return string the link's type.
     */
    function getType();

    /**
     * Return the link's URL.
     *
     * @return string the link's URL.
     */
    function getUrl();

}