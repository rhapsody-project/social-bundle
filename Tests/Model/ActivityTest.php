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
use Rhapsody\SocialBundle\Model\Activity;
use Rhapsody\SocialBundle\Model\ContentInterface;
use Rhapsody\SocialBundle\Model\ActivitySourceInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Util\ClassUtils;

class ActivityTest extends TestCase
{

    public function testId()
    {
        $obj = $this->getActivity();
        $this->assertNull($obj->getId());

        $obj->setId('foo');
        $this->assertEquals('foo', $obj->getId());
    }

    public function testContent()
    {
        $obj = $this->getActivity();
        $this->assertNull($obj->getContent());

        $content = $this->getMockBuilder(ContentInterface::class)->getMock();
        $obj->setContent($content);
        $this->assertEquals($content, $obj->getContent());
    }

    public function testContentType()
    {
        $obj = $this->getActivity();
        $this->assertNull($obj->getContentType());

        $content = $this->getMockBuilder(ContentInterface::class)->getMock();
        $obj->setContent($content);
        $this->assertEquals(ClassUtils::getClass($content), $obj->getContentType());
    }

    public function testCreated()
    {
        $obj = $this->getActivity();
        $this->assertNotNull($obj->getCreated());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setCreated($date);
        $this->assertEquals($date, $obj->getCreated());
    }

    public function testEndorsementCount()
    {
        $obj = $this->getActivity();
        $this->assertEquals(0, $obj->getEndorsementCount());

        $obj->setEndorsementCount(5);
        $this->assertEquals(5, $obj->getEndorsementCount());
    }

    public function testLastModified()
    {
        $obj = $this->getActivity();
        $this->assertNotNull($obj->getLastModified());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setLastModified($date);
        $this->assertEquals($date, $obj->getLastModified());
    }

    public function testShareCount()
    {
        $obj = $this->getActivity();
        $this->assertEquals(0, $obj->getShareCount());

        $obj->setShareCount(5);
        $this->assertEquals(5, $obj->getShareCount());
    }

    public function testSource()
    {
        $obj = $this->getActivity();
        $this->assertNull($obj->getSource());

        $source = $this->getMockBuilder(ActivitySourceInterface::class)->getMock();
        $obj->setSource($source);
        $this->assertEquals($source, $obj->getSource());
    }

    public function testSourceType()
    {
        $obj = $this->getActivity();
        $this->assertNull($obj->getSourceType());

        $source = $this->getMockBuilder(ActivitySourceInterface::class)->getMock();
        $obj->setSource($source);
        $this->assertEquals(ClassUtils::getClass($source), $obj->getSourceType());
    }

    public function testText()
    {
        $obj = $this->getActivity();
        $this->assertNull($obj->getText());

        $obj->setText('bar');
        $this->assertEquals('bar', $obj->getText());
    }

    public function testType()
    {
        $obj = $this->getActivity();
        $this->assertNull($obj->getType());

        $obj->setType('quux');
        $this->assertEquals('quux', $obj->getType());
    }

    public function testUser()
    {
        $obj = $this->getActivity();
        $this->assertNull($obj->getUser());

        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $obj->setUser($user);
        $this->assertEquals($user, $obj->getUser());
    }

    /**
     * @return Activity
     */
    protected function getActivity()
    {
        return $this->getMockForAbstractClass('Rhapsody\SocialBundle\Model\Activity');
    }

}
