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
use Rhapsody\SocialBundle\Model\AffiliationRequest;
use Symfony\Component\Security\Core\User\UserInterface;

class AffiliationRequestTest extends TestCase
{

    public function testId()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertNull($obj->getId());

        $obj->setId('foo');
        $this->assertEquals('foo', $obj->getId());
    }

    public function testAcceptedOn()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertNull($obj->getAcceptedOn());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setAcceptedOn($date);
        $this->assertEquals($date, $obj->getAcceptedOn());
    }

    public function testCreated()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertNotNull($obj->getCreated());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setCreated($date);
        $this->assertEquals($date, $obj->getCreated());
    }

    public function testExpiresAt()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertNull($obj->getExpiresAt());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setExpiresAt($date);
        $this->assertEquals($date, $obj->getExpiresAt());
    }

    public function testIsAccepted()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertFalse($obj->isAccepted());

        $date = new \DateTime('2017-09-04 14:20:39');
        $obj->setAcceptedOn($date);
        $this->assertTrue($obj->isAccepted());
    }

    public function testIsExpiredReturnsFalseIfExpirationIsFutureDate()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertFalse($obj->isExpired());

        // ** A request that has an expiration date in the future
        $date = new \DateTime;
        $date->add(new \DateInterval('P1D'));

        $obj->setExpiresAt($date);
        $this->assertFalse($obj->isExpired());
    }

    public function testIsExpiredReturnsTrueIfExpirationIsPastDate()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertFalse($obj->isExpired());

        // ** A request that has an expiration date in the future
        $date = new \DateTime;
        $date->sub(new \DateInterval('P1D'));

        $obj->setExpiresAt($date);
        $this->assertTrue($obj->isExpired());
    }

    public function testRecipient()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertNull($obj->getRecipient());

        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $obj->setRecipient($user);
        $this->assertEquals($user, $obj->getRecipient());
    }

    public function testRequestedBy()
    {
        $obj = $this->getAffiliationRequest();
        $this->assertNull($obj->getRequestedBy());

        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $obj->setRequestedBy($user);
        $this->assertEquals($user, $obj->getRequestedBy());
    }

    /**
     * @return AffiliationRequest
     */
    protected function getAffiliationRequest()
    {
        return $this->getMockForAbstractClass('Rhapsody\SocialBundle\Model\AffiliationRequest');
    }

}
