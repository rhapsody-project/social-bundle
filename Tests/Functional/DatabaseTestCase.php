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
namespace Rhapsody\SocialBundle\Tests\Functional;

/**
 * A functional test case.
 *
 * Functional tests actually instantiate the application kernel and parse
 * configuration, allowing their tests to be more representative of the real
 * world.
 *
 * @author sean.quinn
 *
 */
abstract class DatabaseTestCase extends FunctionalTestCase
{

    /**
     * The object manager
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected static $objectManager;


    /**
     *
     */
    abstract protected static function getDatabase();

    /**
     *
     */
    abstract protected static function getDatabaseServiceName();

    /**
     * Return the configured MongoDB server address.
     *
     * @return string
     */
    abstract protected static function getServer();

    /**
     * Returns the database connection for this test case.
     *
     * @return mixed The database connection.
     */
    public function getConnection()
    {
        return $this->getObjectManager()->getConnection();
    }

    public function getObjectManager()
    {
        if (null === static::$objectManager) {
            $container = $this->getContainer();
            static::$objectManager = $container->get(static::getDatabaseServiceName())->getManager();
        }
        return static::$objectManager;
    }

    protected function getRepositoryFor($className)
    {
        return $this->getObjectManager()->getRepository($className);
    }

    /**
     * This function should reset the database to a clean state for subsequent
     * tests.
     *
     * If you want this function to run after each unit test, add the
     * <code>after</code> annotation.
     *
     * @throws \Exception
     */
    protected function resetDatabase()
    {
        throw new \Exception('Reset database must be defined by a database specific test cases.');
    }

    protected function setUp()
    {
        parent::setUp();

        // TODO: This was encapsulated in an if-null condition, we've removed that since the container is resettable.
        self::bootKernel(static::$options);
    }

    protected function tearDown()
    {
        // ** Reset the database after this test completes.
        //$this->resetDatabase();

        // **
        // Close the object manager if it is not yet null and ensure that we
        // set it to null, which will make it more likely to be garbage
        // collected and allow memory to be released. We can't use unset()
        // because the object manager is a static variable. [SWQ]
        if (null !== static::$objectManager) {
            static::$objectManager->close();
        }
        static::$objectManager = null;
        parent::tearDown();
    }

}