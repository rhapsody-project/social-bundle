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
use Rhapsody\SocialBundle\Model\SocialContext;

class SocialContextTest extends TestCase
{

    public function testId()
    {
        $obj = $this->getSocialContext();
        $this->assertNull($obj->getId());

        $obj->setId('foo');
        $this->assertEquals('foo', $obj->getId());
    }

    public function testCreated()
    {
        $obj = $this->getSocialContext();
        $this->assertNotNull($obj->getCreated());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setCreated($date);
        $this->assertEquals($date, $obj->getCreated());
    }

    public function testLastIndexed()
    {
        $obj = $this->getSocialContext();
        $this->assertNull($obj->getLastIndexed());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setLastIndexed($date);
        $this->assertEquals($date, $obj->getLastIndexed());
    }

    public function testLastModified()
    {
        $obj = $this->getSocialContext();
        $this->assertNotNull($obj->getLastModified());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setLastModified($date);
        $this->assertEquals($date, $obj->getLastModified());
    }

    public function isEnabled()
    {
        $obj = $this->getSocialContext();
        $this->assertTrue($obj->isEnabled());

        $obj->setEnabled(true);
        $this->assertTrue($obj->isEnabled());

        $obj->setEnabled(false);
        $this->assertFalse($obj->isEnabled());
    }

    /**
     * @return SocialContext
     */
    protected function getSocialContext()
    {
        return $this->getMockForAbstractClass('Rhapsody\SocialBundle\Model\SocialContext');
    }

}
