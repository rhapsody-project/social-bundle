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
use Rhapsody\SocialBundle\Model\Share;
use Rhapsody\SocialBundle\Model\ShareableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ShareTest extends TestCase
{

    public function testId()
    {
        $obj = $this->getShare();
        $this->assertNull($obj->getId());

        $obj->setId('foo');
        $this->assertEquals('foo', $obj->getId());
    }

    public function testDate()
    {
        $obj = $this->getShare();
        $this->assertNotNull($obj->getDate());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setDate($date);
        $this->assertEquals($date, $obj->getDate());
    }

    public function testShared()
    {
        $obj = $this->getShare();
        $this->assertNull($obj->getShared());

        $shared = $this->getMockBuilder(ShareableInterface::class)->getMock();
        $obj->setShared($shared);
        $this->assertEquals($shared, $obj->getShared());
    }

    public function testUser()
    {
        $obj = $this->getShare();
        $this->assertNull($obj->getUser());

        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $obj->setUser($user);
        $this->assertEquals($user, $obj->getUser());
    }

    /**
     * @return Share
     */
    protected function getShare()
    {
        return $this->getMockForAbstractClass('Rhapsody\SocialBundle\Model\Share');
    }

}
