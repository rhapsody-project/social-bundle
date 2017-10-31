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
namespace Rhapsody\SocialBundle\Test\Doctrine\ODM\MongoDB;

use PHPUnit\Framework\TestCase;
use Rhapsody\CommonsBundle\Test\DataFixtureAwareTestCaseInterface;

/**
 *
 */
abstract class MongoDbTestCase extends TestCase implements DataFixtureAwareTestCaseInterface
{

    /* (non-PHPDoc)
     * @see \Rhapsody\CommonsBundle\Test\Traits\DataFixtureTestCaseTrait
     */
    use \Rhapsody\CommonsBundle\Test\Traits\DataFixtureTestCaseTrait;

    /* (non-PHPDoc)
     * @see \Rhapsody\SocialBundle\Test\Traits\MongoDBSupprtTrait
     */
    use \Rhapsody\SocialBundle\Test\Traits\MongoDbSupprtTrait;

    /**
     * @{inheritDoc}
     * @see \PHPUnit\Framework\TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        static::setUpDataFixtures();
    }

    /**
     * Return the configured object manager.
     *
     * @return ObjectManager the object manager
     */
    public function getObjectManager()
    {
        return $this->dm;
    }

    /**
     * {@inheritDoc}
     *
     * Setting up the <code>MongoDBTestCase</code> involves a little bit more
     * work, mainly the instantiation of the document manager, unit of work,
     * and data fixtures.
     *
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp()
    {
        parent::setUp();
        $this->dm = $this->createTestDocumentManager();
        $this->uow = $this->dm->getUnitOfWork();

        // ** Load the data fixtures explicitly (don't use @before).
        $this->loadDataFixtures();
    }

    /**
     * {@inheritDoc}
     * @see \PHPUnit\Framework\TestCase::tearDown()
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->resetDatabase();

        unset($this->dm);
        unset($this->referenceRepository);
        unset($this->uow);
    }
}
