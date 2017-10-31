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
namespace Rhapsody\SocialBundle\Tests\Functional\Repository\ODM\MongoDB;

use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\JackDorseyFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\MarkZuckerbergFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\TomAndersonFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity\CatVideoFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity\EgyptianRevolutionFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity\HudsonRiverPlaneCrashFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity\RealFakeNewsFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity\RoyalWeddingAnnouncementFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity\StatusUpdateFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\SocialContext\BlogFixture;

/**
 *
 */
class ActivityRepositoryTest extends RepositoryTestCase
{
    /** {@inheritdoc} */
    protected static $objectClassName = 'Rhapsody\SocialBundle\Tests\Functional\Dummy\Bundle\TestBundle\Document\Activity';

    /**
     * {@inheritdoc}
     * @see \Rhapsody\CommonsBundle\Test\Traits\DataFixtureTestCaseTrait::setUpDataFixtures()
     */
    public static function setUpDataFixtures()
    {
        static::$dataFixtures = array(
            // ** Users
            new JackDorseyFixture(),
            new MarkZuckerbergFixture(),
            new TomAndersonFixture(),

            // ** The social context fixture.
            new BlogFixture(),

            // ** Activities
            new CatVideoFixture(),
            new EgyptianRevolutionFixture(),
            new HudsonRiverPlaneCrashFixture(),
            new RealFakeNewsFixture(),
            new RoyalWeddingAnnouncementFixture(),
            new StatusUpdateFixture(),
        );
    }

    public function testFindByActivitySource()
    {
        $objectManager = $this->getObjectManager();

        $activitySource = $this->getReference('socialcontext-blog');

        $activity1 = $this->getReference('activity-jdorsey-hudsonriverplanecrash');
        $activity1->setSource($activitySource);
        $objectManager->persist($activity1);

        $activity2 = $this->getReference('activity-jdorsey-royalweddingannouncement');
        $activity2->setSource($activitySource);
        $objectManager->persist($activity2);

        $activity3 = $this->getReference('activity-mzuckerberg-egyptianrevolution');
        $activity3->setSource($activitySource);
        $objectManager->persist($activity3);

        $objectManager->flush();

        $actual = $this->repository->findByActivitySource($activitySource);
        $this->assertNotNull($actual);
        $this->assertNotEmpty($actual);
        $this->assertCount(3, $actual);
    }

    public function testFindByActivitySourceWithLimitAndOffset()
    {
        $objectManager = $this->getObjectManager();

        $activitySource = $this->getReference('socialcontext-blog');

        $activity1 = $this->getReference('activity-jdorsey-hudsonriverplanecrash');
        $activity1->setSource($activitySource);
        $objectManager->persist($activity1);

        $activity2 = $this->getReference('activity-jdorsey-royalweddingannouncement');
        $activity2->setSource($activitySource);
        $objectManager->persist($activity2);

        $activity3 = $this->getReference('activity-mzuckerberg-egyptianrevolution');
        $activity3->setSource($activitySource);
        $objectManager->persist($activity3);

        $objectManager->flush();

        $actual = $this->repository->findByActivitySource($activitySource, $limit = 2, $offset = 1);
        $this->assertCount(2, $actual);
        $this->assertContains($activity1, $actual);
        $this->assertContains($activity2, $actual);
        $this->assertNotContains($activity3, $actual);
    }

    public function testFindByUser()
    {
        $user = $this->getReference('user-mzuckerberg');

        $actual = $this->repository->findByUser($user);
        $this->assertCount(3, $actual);

        $expected = $this->getReference('activity-mzuckerberg-egyptianrevolution');
        $this->assertContains($expected, $actual);

        $expected = $this->getReference('activity-mzuckerberg-realfakenews');
        $this->assertContains($expected, $actual);

        $expected = $this->getReference('activity-mzuckerberg-statusupdate');
        $this->assertContains($expected, $actual);
    }

    public function testFindByUserWithLimitAndOffset()
    {
        $user = $this->getReference('user-mzuckerberg');

        $actual = $this->repository->findByUser($user, $limit = 2, $offset = 1);
        $this->assertCount(2, $actual);

        $expected = $this->getReference('activity-mzuckerberg-realfakenews');
        $this->assertContains($expected, $actual);

        $expected = $this->getReference('activity-mzuckerberg-egyptianrevolution');
        $this->assertContains($expected, $actual);
    }

    public function testFindOneById()
    {
        $activity = $this->getReference('activity-tanderson-catvideo');

        $actual = $this->repository->findOneById($activity->getId());
        $this->assertSame($activity, $actual);
    }

    public function testGetReferenceForActivitySource()
    {
        $activitySource = $this->getReference('socialcontext-blog');

        $m = new \ReflectionMethod($this->repository, 'getReferenceForActivitySource');
        $m->setAccessible(true);

        $actual = $m->invoke($this->repository, $activitySource);
        $this->assertEquals(new \MongoId($activitySource->getId()), $actual);

        $actual = $m->invoke($this->repository, $activitySource->getId());
        $this->assertEquals(new \MongoId($activitySource->getId()), $actual);
    }

    public function testGetReferenceForUser()
    {
        $user = $this->getReference('user-mzuckerberg');

        $m = new \ReflectionMethod($this->repository, 'getReferenceForUser');
        $m->setAccessible(true);

        $actual = $m->invoke($this->repository, $user);
        $this->assertEquals(new \MongoId($user->getId()), $actual);

        $actual = $m->invoke($this->repository, $user->getId());
        $this->assertEquals(new \MongoId($user->getId()), $actual);
    }

}
