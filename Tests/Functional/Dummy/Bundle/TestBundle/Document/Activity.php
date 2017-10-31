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
namespace Rhapsody\SocialBundle\Tests\Functional\Dummy\Bundle\TestBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Rhapsody\SocialBundle\Model\Activity as ActivityModel;
use Rhapsody\SocialBundle\Model\CommentInterface;

/**
 * A simple social context.
 *
 * @author Sean.Quinn
 * @ODM\Document(collection="activities", repositoryClass="Rhapsody\SocialBundle\Repository\ODM\MongoDB\ActivityRepository")
 * @ODM\InheritanceType("COLLECTION_PER_CLASS")
 */
class Activity extends ActivityModel
{

    /** @ODM\Id */
    protected $id;


    /** @ODM\ReferenceMany(targetDocument="Comment" mappedBy="parent") */
    protected $comments;

    public function __construct()
    {
        parent::__construct();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection;
    }

    public function addComment(CommentInterface $comment)
    {
        $comment->setParent($this);
        $this->comments->add($comment);
        return $this->comments;
    }

}
