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
namespace Rhapsody\SocialBundle\Test\Traits;

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 *
 */
trait MongoDbSupprtTrait
{

    /** @var \Doctrine\ODM\MongoDB\DocumentManager */
    protected $dm;

    /** @var \Doctrine\ODM\MongoDB\UnitOfWork */
    protected $uow;

    protected function createMetadataDriverImpl()
    {
        return AnnotationDriver::create(__DIR__ . '/../../Tests/Fixtures/Document');
    }

    /**
     *
     * @return \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected function createTestDocumentManager()
    {
        $server = $this->getServer();

        $config = $this->getConfiguration();
        $conn = new Connection($server, [], $config);
        return DocumentManager::create($conn, $config);
    }

    /**
     *
     * @return \Doctrine\ODM\MongoDB\Configuration
     */
    protected function getConfiguration()
    {
        $config = new Configuration();

        $config->setProxyDir(__DIR__ . '/../../Resources/tests/Proxies');
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir(__DIR__ . '/../../Resources/tests/Hydrators');
        $config->setHydratorNamespace('Hydrators');
        $config->setPersistentCollectionDir(__DIR__ . '/../../Resources/tests/PersistentCollections');
        $config->setPersistentCollectionNamespace('PersistentCollections');
        $config->setDefaultDB($this->getDatabase());
        $config->setMetadataDriverImpl($this->createMetadataDriverImpl());
        return $config;
    }

    private function getDatabase()
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

    /**
     *
     * @param unknown $documentName
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepositoryFor($className)
    {
        return $this->dm->getRepository($className);
    }

    /**
     * Return the configured MongoDB server address.
     *
     * @return string|unknown
     */
    private function getServer()
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
        $result = $this->dm->getConnection()
            ->selectDatabase($database)
            ->command(array('buildInfo' => 1));
        return $result['version'];
    }

    protected function requireVersion($installedVersion, $requiredVersion, $operator, $message)
    {
        if (version_compare($installedVersion, $requiredVersion, $operator)) {
            $this->markTestSkipped($message);
        }
    }

    protected function requireMongoDB32($message)
    {
        $this->requireVersion($this->getServerVersion(), '3.2.0', '<', $message);
    }

    protected function requireMongoDB34($message)
    {
        $this->requireVersion($this->getServerVersion(), '3.4.0', '<', $message);
    }

    protected function resetDatabase()
    {
        if ($this->dm) {
            $database = $this->getDatabase();

            // Check if the database exists. Calling listCollections on a non-existing
            // database in a sharded setup will cause an invalid command cursor to be
            // returned
            $databases = $this->dm->getConnection()->listDatabases();
            $databaseNames = array_map(function ($database) { return $database['name']; }, $databases['databases']);
            if (!in_array($database, $databaseNames)) {
                return;
            }

            $collections = $this->dm->getConnection()->selectDatabase($database)->listCollections();
            foreach ($collections as $collection) {
                $collection->drop();
            }
        }
    }
    protected function skipOnMongoDB34($message)
    {
        $this->requireVersion($this->getServerVersion(), '3.4.0', '>=', $message);
    }

    protected function skipTestIfNotSharded($className)
    {
        $result = $this->dm->getDocumentDatabase($className)->command(['listCommands' => true]);
        if (!$result['ok']) {
            $this->markTestSkipped('Could not check whether server supports sharding');
        }

        if (!array_key_exists('shardCollection', $result['commands'])) {
            $this->markTestSkipped('Test skipped because server does not support sharding');
        }
    }

}
