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
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Affiliation\AndersonDorseyAffiliationFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Affiliation\AndersonZuckerbergAffiliationFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Affiliation\DorseyAndersonAffiliationFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Affiliation\DorseyZuckerbergAffiliationFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Affiliation\ZuckerbergAndersonAffiliationFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Affiliation\ZuckerbergDorseyAffiliationFixture;

/**
 *
 */
class AffiliationRepositoryTest extends RepositoryTestCase
{
    /** {@inheritdoc} */
    protected static $objectClassName = 'Rhapsody\SocialBundle\Tests\Functional\Dummy\Bundle\TestBundle\Document\Affiliation';

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

            // ** Affiliations
            new AndersonDorseyAffiliationFixture(),
            new AndersonZuckerbergAffiliationFixture(),
            new DorseyAndersonAffiliationFixture(),
            new DorseyZuckerbergAffiliationFixture(),
            new ZuckerbergAndersonAffiliationFixture(),
            new ZuckerbergDorseyAffiliationFixture()
        );
    }

    public function testFindByAffiliatedUser()
    {
        $user = $this->getReference('user-tanderson');

        $actual = $this->repository->findByAffiliation($user);
        $this->assertNotNull($actual);
        $this->assertNotEmpty($actual);
        $this->assertCount(2, $actual);
    }

    public function testFindByUser()
    {
        $user = $this->getReference('user-jdorsey');

        $actual = $this->repository->findByUser($user);
        $this->assertNotNull($actual);
        $this->assertNotEmpty($actual);
        $this->assertCount(2, $actual);
    }

    public function testFindOneById()
    {
        $affiliation = $this->getReference('affiliation-jdorsey-mzuckerberg');

        $actual = $this->repository->findOneById($affiliation->getId());
        $this->assertSame($affiliation, $actual);
    }

}