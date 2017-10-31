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

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

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
abstract class FunctionalTestCase extends KernelTestCase
{

    /**
     * An array of options to pass into the kernel boot.
     * @var array
     */
    protected static $options = array();

    /**
     * Create the kernel.
     *
     * Unlike the kernels normally instantiated by <code>KernelTestCases</code>
     * this functional test supports the dynamic nature of the bundles multiple
     * test cases.
     *
     * @param array $options
     * @throws \InvalidArgumentException
     * @return Kernel The test application kernel.
     */
    protected static function createKernel(array $options = array())
    {
        $class = self::getKernelClass();
        $options = array_merge(static::$options, $options);

        if (!isset($options['test_case'])) {
            throw new \InvalidArgumentException('The option "test_case" must be set.');
        }

        $testCase = static::extractValue($options, 'test_case');
        $rootConfig = static::extractValue($options, 'root_config', 'config.yml');
        $environment = static::extractValue($options, 'environment', strtolower(static::getVarDir().$testCase));
        $debug = static::extractValue($options, 'debug', true);
        return new $class(static::getVarDir(), $testCase, $rootConfig, $environment, $debug, $options);
    }

    /**
     * Deletes the temporary directory.
     */
    protected static function deleteTmpDir()
    {
        if (!file_exists($dir = sys_get_temp_dir().'/'.static::getVarDir())) {
            return;
        }

        $fs = new Filesystem();
        $fs->remove($dir);
    }

    private static function extractValue($array, $key, $default = null)
    {
        if (isset($array[$key])) {
            $value = $array[$key];
            unset($array[$key]);
            return $value;
        }
        return $default;
    }

    protected static function getContainer()
    {
        if (null === static::$kernel) {
            throw new \RuntimeException('Kernel is null. Unable to retrieve container.');
        }
        return static::$kernel->getContainer();
    }

    /**
     * Return the kernel's classname.
     *
     * Instead of resolving the kernel class for the project, we want to
     * actually use the one that is embedded in the functional tests of the
     * bundle.
     *
     * @return string
     */
    protected static function getKernelClass()
    {
        require_once __DIR__.'/Dummy/app/AppKernel.php';

        return 'Rhapsody\SocialBundle\Tests\Functional\Dummy\app\AppKernel';
    }

    /**
     * Return the <code>/var</code> directory for the instantiated kernel.
     *
     * @return string the var directory.
     */
    protected static function getVarDir()
    {
        return substr(strrchr(get_called_class(), '\\'), 1);
    }

    /**
     * @{inheritDoc}
     * @see \PHPUnit\Framework\TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        static::deleteTmpDir();
    }

    /**
     * @{inheritDoc}
     * @see \PHPUnit\Framework\TestCase::tearDownAfterClass()
     */
    public static function tearDownAfterClass()
    {
        static::deleteTmpDir();
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase::tearDown()
     */
    protected function tearDown()
    {
        parent::tearDown();
        //static::$kernel = null;
    }

}