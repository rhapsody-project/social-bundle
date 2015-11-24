<?php
/* Copyright (c) 2013 Rhapsody Project
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
namespace Rhapsody\SocialBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 *
 * @author Sean.Quinn
 * @since 1.0
 */
class RhapsodySocialExtension extends Extension
{

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\DependencyInjection\Extension\ExtensionInterface::load()
	 */
	public function load(array $configs, ContainerBuilder $container)
	{
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('delegate.xml');
		$loader->load('events.xml');
		$loader->load('factory.xml');
		$loader->load('form.xml');
		$loader->load('twig.xml');
		$loader->load('validator.xml');

		$processor = new Processor();
		$configuration = new Configuration();
		$config = $processor->processConfiguration($configuration, $configs);
		if ('custom' !== $config['db_driver']) {
			$loader->load(sprintf('%s.xml', $config['db_driver']));
		}

		//$container->setParameter('rhapsody_social.storage', $config['db_driver']);
		//$container->setParameter('rhapsody_social.activity_class', $config['activity']['activity_class']);

		$this->loadParameters($config, $container);
		$this->remapParametersNamespaces($config, $container, array(
			'activity' => array(
				'activity_class'        => 'rhapsody_social.model.activity.class',
			),
			'profile' => array(
				'profile_class'         => 'rhapsody_social.model.profile.class',
			),
		));
		$container->setAlias('rhapsody_social.activity_manager', $config['activity']['activity_manager']);
		//$container->setParameter('rhapsody_social.activity_manager_name', $config['activity_manager_name']);
	}

	private function loadParameters(array $config, ContainerBuilder $container)
	{
		foreach ( $config as $groupName => $group ) {
			if (is_array($group)) {
				foreach ( $group as $name => $value ) {
					if (is_array($value)) {
						foreach ( $value as $subname => $subvalue ) {
							$container->setParameter(sprintf('rhapsody_social.%s.%s.%s', $groupName, $name, $subname), $subvalue);
						}
					}
					else {
						$container->setParameter(sprintf('rhapsody_social.%s.%s', $groupName, $name), $value);
					}
				}
			}
			else {
				$container->setParameter(sprintf('rhapsody_social.%s', $groupName), $group);
			}
		}
	}

	protected function remapParameters(array $config, ContainerBuilder $container, array $map)
	{
		foreach ( $map as $name => $paramName ) {
			if (array_key_exists($name, $config)) {
				$container->setParameter($paramName, $config[$name]);
			}
		}
	}

	protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
	{
		foreach ( $namespaces as $ns => $map ) {
			if ($ns) {
				if (! array_key_exists($ns, $config)) {
					continue;
				}
				$namespaceConfig = $config[$ns];
			}
			else {
				$namespaceConfig = $config;
			}
			if (is_array($map)) {
				$this->remapParameters($namespaceConfig, $container, $map);
			}
			else {
				foreach ( $namespaceConfig as $name => $value ) {
					$container->setParameter(sprintf($map, $name), $value);
				}
			}
		}
	}
}
