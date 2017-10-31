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
namespace Rhapsody\SocialBundle\Factory;

use Rhapsody\SocialBundle\Builder\ActivityBuilder;
use Rhapsody\SocialBundle\Builder\ActivitySourceBuilder;
use Rhapsody\SocialBundle\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Factory
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityBuilderFactory extends AbstractAuthorizationAwareFactory
{
	private $activityClass;
	private $activitySourceClass;

	/**
	 * Instantiates a new post builder factory.
	 *
	 * @param Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
	 *    The security context.
	 * @param \Rhapsody\SocialBundle\Validator\ValidatorInterface $validator
	 *    The validator.
	 * @param string $class
	 *    The class to be created by the builder returned by the factory.
	 */
	public function __construct(AuthorizationCheckerInterface $authorizationChecker, ValidatorInterface $validator, $class)
	{
		parent::__construct($authorizationChecker, $validator, $class);

		if ($this->validator !== null) {
			// Add constraints here...
		}
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Factory\BuilderFactoryInterface::createBuilder()
	 */
	public function createBuilder()
	{
		return new ActivityBuilder($this->getAuthorizationChecker(), $this->getValidator(), $this->class);
	}

}
