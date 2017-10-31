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

use Rhapsody\CommonsBundle\Test\DataFixtureAwareTestCaseInterface;
use Rhapsody\DataFixturesBundle\Purger\MongoDBPurger;
use Rhapsody\SocialBundle\Tests\Functional\RepositoryTestCase as BaseRepositoryTestCase;

/**
 *
 * @author sean.quinn
 *
 */
abstract class RepositoryTestCase extends BaseRepositoryTestCase implements DataFixtureAwareTestCaseInterface
{

    /* (non-PHPDoc)
     * @see \Rhapsody\CommonsBundle\Test\Traits\DataFixtureTestCaseTrait
     */
    use \Rhapsody\CommonsBundle\Test\Traits\DataFixtureTestCaseTrait;

    /**
     * @{inheritDoc}
     * @see \PHPUnit\Framework\TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        static::$options = array(
            'test_case' => 'MongoDB',
            'rhapsody_social.tests.mongodb.server' => static::getServer(),
            'rhapsody_social.tests.mongodb.db' => static::getDatabase(),
        );
        static::setUpDataFixtures();
    }

    /**
     * Configures the data fixtures to use for this test case.
     */
    public static function setUpDataFixtures()
    {
        // Empty. Tests that extend this test case should implement.
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Tests\Functional\DatabaseTestCase::getDatabase()
     */
    protected static function getDatabase()
    {
        // **
        // The key identifying the entry in <code>$GLOBALS</code> to look for
        // the configured MongoDB database name. It is defined in this function
        // because traits can't have constant variable definitions. [SWQ]
        $key = 'RHAPSODY_SOCIALBUNDLE_DOCTRINE_MONGODB_DATABASE';
        if (isset($GLOBALS[$key])) {
            return $GLOBALS[$key];
        }
        return 'rhapsody_socialbundle_tests';
    }

    protected static function getDatabaseServiceName()
    {
        return 'doctrine_mongodb';
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Tests\Functional\DatabaseTestCase::getServer()
     */
    protected static function getServer()
    {
        if (null !== getenv('DOCTRINE_MONGODB_SERVER')) {
            return getenv('DOCTRINE_MONGODB_SERVER');
        }

        // **
        // The key identifying the entry in <code>$GLOBALS</code> to look for
        // the configured MongoDB server address. It is defined in this function
        // because traits can't have constant variable definitions. [SWQ]
        $key = 'RHAPSODY_SOCIALBUNDLE_DOCTRINE_MONGODB_SERVER';
        if (isset($GLOBALS[$key])) {
            return $GLOBALS[$key];
        }
        return 'mongodb://localhost:27017';
    }

    protected function getServerVersion()
    {
        $database = $this->getDatabase();
        $result = $this->getConnection()
            ->selectDatabase($database)
            ->command(array('buildInfo' => 1));
        return $result['version'];
    }

    protected function resetDatabase()
    {
        $objectManager = $this->getObjectManager();
        $purger = new MongoDBPurger($objectManager);

        $purger->purge();
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
        unset($this->referenceRepository);
    }

}