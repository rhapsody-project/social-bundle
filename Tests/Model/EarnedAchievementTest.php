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
use Rhapsody\SocialBundle\Model\EarnedAchievement;
use Rhapsody\SocialBundle\Model\AchievementInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Rhapsody\SocialBundle\Model\SocialContextInterface;

class EarnedAchievementTest extends TestCase
{

    public function testId()
    {
        $obj = $this->getEarnedAchievement();
        $this->assertNull($obj->getId());

        $obj->setId('foo');
        $this->assertEquals('foo', $obj->getId());
    }

    public function testAchievement()
    {
        $obj = $this->getEarnedAchievement();
        $this->assertNull($obj->getAchievement());

        $achievement = $this->getMockBuilder(AchievementInterface::class)->getMock();
        $obj->setAchievement($achievement);
        $this->assertEquals($achievement, $obj->getAchievement());
    }

    public function testDate()
    {
        $obj = $this->getEarnedAchievement();
        $this->assertNotNull($obj->getDate());
    }

    public function testSocialContext()
    {
        $obj = $this->getEarnedAchievement();
        $this->assertNull($obj->getSocialContext());

        $socialContext = $this->getMockBuilder(SocialContextInterface::class)->getMock();
        $obj->setSocialContext($socialContext);
        $this->assertEquals($socialContext, $obj->getSocialContext());
    }

    public function testUser()
    {
        $obj = $this->getEarnedAchievement();
        $this->assertNull($obj->getUser());

        $user = $this->getMockBuilder(UserInterface::class)->getMock();
        $obj->setUser($user);
        $this->assertEquals($user, $obj->getUser());
    }

    /**
     * @return EarnedAchievement
     */
    protected function getEarnedAchievement()
    {
        return $this->getMockForAbstractClass('Rhapsody\SocialBundle\Model\EarnedAchievement');
    }

}
