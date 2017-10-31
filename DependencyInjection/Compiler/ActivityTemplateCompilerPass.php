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
namespace Rhapsody\SocialBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 *
 * @author    Sean.Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\DependencyInjection\Compiler
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityTemplateCompilerPass implements CompilerPassInterface
{
	protected $class = 'rhapsody.social.twig.activity_twig_template_manager';
	//protected $class = 'rhapsody_social.activity_template_manager';
	protected $tag = 'rhapsody.social.activity_template';

	public function process(ContainerBuilder $container)
	{
		if (false === $container->hasDefinition($this->class)) {
			return;
		}

		$definition = $container->getDefinition($this->class);

		// Extensions must always be registered before everything else.
		// For instance, global variable definitions must be registered
		// afterward. If not, the globals from the extensions will never
		// be registered.
		$calls = $definition->getMethodCalls();
		$definition->setMethodCalls(array());
		foreach ( $container->findTaggedServiceIds($this->tag) as $id => $attributes ) {
			$definition->addMethodCall('addManagedTemplate', array(
					new Reference($id)
			));
		}
		$definition->setMethodCalls(array_merge($definition->getMethodCalls(), $calls));
	}
}

