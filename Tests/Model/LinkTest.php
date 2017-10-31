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
use Rhapsody\SocialBundle\Model\SocialContextInterface;
use Rhapsody\SocialBundle\Model\Link;

class LinkTest extends TestCase
{

    public function testId()
    {
        $obj = $this->getLink();
        $this->assertNull($obj->getId());

        $obj->setId('foo');
        $this->assertEquals('foo', $obj->getId());
    }

    public function testPreviewImages()
    {
        $obj = $this->getLink();
        $this->assertEmpty($obj->getPreviewImages());

        $expected = ['http://one', 'http://two'];
        $obj->setPreviewImages($expected);
        $this->assertEquals($expected, $obj->getPreviewImages());
    }

    public function testSummary()
    {
        $obj = $this->getLink();
        $this->assertNull($obj->getSummary());

        $obj->setSummary('bar');
        $this->assertEquals('bar', $obj->getSummary());
    }

    public function testType()
    {
        $obj = $this->getLink();
        $this->assertNull($obj->getType());

        $obj->setType('quux');
        $this->assertEquals('quux', $obj->getType());
    }

    public function testUrl()
    {
        $obj = $this->getLink();
        $this->assertNull($obj->getUrl());

        $obj->setUrl('http://wow');
        $this->assertEquals('http://wow', $obj->getUrl());
    }

    public function testSocialContext()
    {
        $obj = $this->getLink();
        $this->assertNull($obj->getSocialContext());

        $socialContext = $this->getMockBuilder(SocialContextInterface::class)->getMock();
        $obj->setSocialContext($socialContext);
        $this->assertEquals($socialContext, $obj->getSocialContext());
    }

    /**
     * @return Link
     */
    protected function getLink()
    {
        return $this->getMockForAbstractClass('Rhapsody\SocialBundle\Model\Link');
    }

}
