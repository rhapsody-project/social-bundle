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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 */
class Configuration implements ConfigurationInterface
{

	private function getSupportedDatabaseDrivers()
	{
		return array('orm','mongodb','couchdb','propel','custom'
		);
	}

	/**
	 * Generates the configuration tree.
	 *
	 * @return TreeBuilder
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('rhapsody_social');

		$supportedDrivers = $this->getSupportedDatabaseDrivers();
		$rootNode->children()
			->scalarNode('db_driver')
				->validate()
					->ifNotInArray($supportedDrivers)
					->thenInvalid('The driver %s is not supported. Please choose one of ' . json_encode($supportedDrivers))
				->end()
				->cannotBeOverwritten()
				->isRequired()
				->cannotBeEmpty()
			->end()
		->end();
		// Using the custom driver requires changing the manager services
		// Using the custom driver requires changing the manager services
		//->validate()
		//		->ifTrue(function($v){return 'custom' === $v['db_driver'] && 'rhapsody.social.doctrine.activity_manager' === $v['service']['activity_manager'];})
		//		->thenInvalid('You need to specify your own activity manager service when using the "custom" driver.')
		//->end()

		$this->addActivitySection($rootNode);
		$this->addMailSection($rootNode);
		$this->addProfileSection($rootNode);
		return $treeBuilder;
	}

	/**
	 * Adds the activity section to the Rhapsody SocialBundle configuration.
	 *
	 * @param ArrayNodeDefinition $node the root node.
	 */
	private function addActivitySection(ArrayNodeDefinition $node)
	{
		$node->children()
			->arrayNode('activity')
				->addDefaultsIfNotSet()
				->canBeUnset()
				->children()
					->scalarNode('allow_comment')->defaultTrue()->treatNullLike(true)->end()
					->scalarNode('allow_endorsement')->defaultTrue()->treatNullLike(true)->end()
					->scalarNode('allow_share')->defaultTrue()->treatNullLike(true)->end()
					->scalarNode('activity_class')->isRequired()->cannotBeEmpty()->end()
					->scalarNode('activity_manager')->defaultValue('rhapsody.social.doctrine.activity_manager')->end()
					->arrayNode('form')
						->addDefaultsIfNotSet()
						->children()
							->scalarNode('type')->defaultValue('rhapsody_social_form_type_activity')->end()
							->scalarNode('name')->defaultValue('rhapsody_social_activity_form')->end()
							->arrayNode('validation_groups')
								->prototype('scalar')->end()
								->treatNullLike(array())
							->end()
						->end()
					->end()
				->end()
			->end()
		->end();
	}

	/**
	 * Adds the <code>mail</code> section to the Rhapsody SocialBundle
	 * configuration.
	 *
	 * @param ArrayNodeDefinition $node the root node.
	 */
	private function addMailSection(ArrayNodeDefinition $node)
	{
		$node->children()
			->arrayNode('mail')
				->addDefaultsIfNotSet()
				->canBeUnset()
				->children()
					->scalarNode('sender_email')->isRequired()->cannotBeEmpty()->end()
					->scalarNode('sender_name')->isRequired()->cannotBeEmpty()->end()
				->end()
			->end()
		->end()
		;
	}

	/**
	 * Adds the profile section to the Rhapsody SocialBundle configuration.
	 *
	 * @param ArrayNodeDefinition $node the root node.
	 */
	private function addProfileSection(ArrayNodeDefinition $node)
	{
		$node->children()
			->arrayNode('profile')
				->addDefaultsIfNotSet()
				->canBeUnset()
				->children()
					->scalarNode('profile_class')->isRequired()->cannotBeEmpty()->end()
				->end()
			->end()
		->end();
	}
}
