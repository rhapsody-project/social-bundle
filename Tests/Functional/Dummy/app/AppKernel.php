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
namespace Rhapsody\SocialBundle\Tests\Functional\Dummy\app;

// get the autoload file
$dir = __DIR__;
$lastDir = null;
while ($dir !== $lastDir) {
    $lastDir = $dir;

    if (file_exists($dir.'/autoload.php')) {
        require_once $dir.'/autoload.php';
        break;
    }

    if (file_exists($dir.'/autoload.php.dist')) {
        require_once $dir.'/autoload.php.dist';
        break;
    }

    if (file_exists($dir.'/vendor/autoload.php')) {
        require_once $dir.'/vendor/autoload.php';
        break;
    }

    $dir = dirname($dir);
}

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Application kernel for functional tests.
 *
 * @author Sean Quinn
 */
class AppKernel extends Kernel
{
    private $varDir;
    private $testCase;
    private $rootConfig;

    /**
     * Additional test parameters that were passed to the kernel during its
     * instantiation.
     *
     * These parameters are mostly useful for defining values that might change
     * between tests, such as the database server or name. While the dummy
     * kernel should be responsible for defining sane defaults for these, it is
     * important that test environments can override them.
     * @var array
     */
    private $testParameters;

    public function __construct($varDir, $testCase, $rootConfig, $environment, $debug, $testParameters = array())
    {
        $testCaseDir = sprintf('%s/%s', $this->getTestCaseDir(), $testCase);
        if (!is_dir($testCaseDir)) {
            throw new \InvalidArgumentException(sprintf('The test case "%s" does not exist under: %s.', $testCase, $this->getTestCaseDir()));
        }
        $this->varDir = $varDir;
        $this->testCase = $testCase;
        $this->testParameters = $testParameters;

        $fs = new Filesystem();
        $rootConfig = sprintf('%s/%s', $testCaseDir, $rootConfig);
        if (!$fs->isAbsolutePath($rootConfig) && !file_exists($rootConfig)) {
            throw new \InvalidArgumentException(sprintf('The root config "%s" does not exist.', $rootConfig));
        }
        $this->rootConfig = $rootConfig;

        parent::__construct($environment, $debug);
    }

    /**
     * {@inheritDoc}
     *
     * Iterates over the collection of bundles specified in the test case's
     * <code>bundles.php</code> file.
     *
     * @see \Symfony\Component\HttpKernel\KernelInterface::registerBundles()
     */
    public function registerBundles()
    {
        $filename = sprintf('%s/%s/bundles.php', $this->getTestCaseDir(), $this->testCase);
        if (!file_exists($filename)) {
            throw new \RuntimeException(sprintf('The bundles file "%s" does not exist.', $filename));
        }
        return include $filename;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/'.$this->varDir.'/'.$this->testCase.'/cache/'.$this->environment;
    }

    /**
     * Return the configuration directory.
     *
     * @return string the configuration directory.
     */
    public function getConfigDir()
    {
        return sprintf('%s/config', $this->getRootDir());
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\HttpKernel\Kernel::getContainerBuilder()
     */
    protected function getContainerBuilder()
    {
        $container = parent::getContainerBuilder();
        $container->getParameterBag()->add($this->getTestParameters());

        return $container;
    }

    protected function getKernelParameters()
    {
        $parameters = parent::getKernelParameters();
        $parameters['kernel.test_case'] = $this->testCase;

        return $parameters;
    }

    public function getLogDir()
    {
        return sys_get_temp_dir().'/'.$this->varDir.'/'.$this->testCase.'/logs';
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * Return the test case directory.
     *
     * @return string the test case directory.
     */
    public function getTestCaseDir()
    {
        return sprintf('%s/tests', $this->getConfigDir());
    }

    protected function getTestParameters()
    {
        return $this->testParameters;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->rootConfig);
    }

    public function serialize()
    {
        return serialize(array($this->varDir, $this->testCase, $this->rootConfig, $this->getEnvironment(), $this->isDebug()));
    }

    public function unserialize($str)
    {
        $a = unserialize($str);
        $this->__construct($a[0], $a[1], $a[2], $a[3], $a[4]);
    }

}
