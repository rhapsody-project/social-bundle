<?php
/* Copyright (c) 2015 Rhapsody Project
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

use Rhapsody\SocialBundle\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Factory
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class AbstractAuthorizationAwareFactory extends AbstractBuilderFactory
{

  /**
   * The authorization checker.
   * @var Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface
   * @access protected
   */
  protected $authorizationChecker;

  /**
   * @param Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
   *    The security context.
   * @param \Rhapsody\SocialBundle\Validator\ValidatorInterface $validator
   *    The validator.
   * @param string $class
   *    The class to be created by the builder returned by the factory.
   */
  public function __construct(AuthorizationCheckerInterface $authorizationChecker, ValidatorInterface $validator, $class = null)
  {
    $this->authorizationChecker = $authorizationChecker;
    $this->validator = $validator;
    $this->class = $class;
  }

  public function getAuthorizationChecker()
  {
    return $this->authorizationChecker;
  }

  /**
   * Assigns a security context to this factory.
   *
   * @param \Symfony\Component\Security\Core\AuthorizationCheckerInterface $securityContext
   *    The security context.
   */
  public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker)
  {
    $this->authorizationChecker = $authorizationChecker;
  }

}
