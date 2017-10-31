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
namespace Rhapsody\SocialBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Rhapsody\SocialBundle\Model\Comment;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentTest extends TestCase
{

    public function testId()
    {
        $obj = $this->getComment();
        $this->assertNull($obj->getId());

        $obj->setId('foo');
        $this->assertEquals('foo', $obj->getId());
    }

    public function testCreated()
    {
        $obj = $this->getComment();
        $this->assertNotNull($obj->getCreated());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setCreated($date);
        $this->assertEquals($date, $obj->getCreated());
    }

    public function testEndorsementCount()
    {
        $obj = $this->getComment();
        $this->assertEquals(0, $obj->getEndorsementCount());

        $obj->setEndorsementCount(5);
        $this->assertEquals(5, $obj->getEndorsementCount());
    }

    public function testText()
    {
        $obj = $this->getComment();
        $this->assertNull($obj->getText());

        $obj->setText('bar');
        $this->assertEquals('bar', $obj->getText());
    }

    public function testUser()
    {
        $obj = $this->getComment();
        $this->assertNull($obj->getUser());

        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $obj->setUser($user);
        $this->assertEquals($user, $obj->getUser());
    }

    /**
     * @return Comment
     */
    protected function getComment()
    {
        return $this->getMockForAbstractClass('Rhapsody\SocialBundle\Model\Comment');
    }

}
