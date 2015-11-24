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

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Document
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class AbstractBuilderFactory implements BuilderFactoryInterface
{

  /**
   * The name of the class that this factory will return a builder for.
   * @var string
   * @access protected
   */
  protected $class;

  protected $validator;

  /**
   * (non-PHPDoc)
   * @see \Rhapsody\SocialBundle\Factory\BuilderFactoryInterface::getClass()
   */
  public function getClass()
  {
    return $this->class;
  }

  /**
   * (non-PHPDoc)
   * @see \Rhapsody\SocialBundle\Factory\BuilderFactoryInterface::getValidator()
   */
  public function getValidator()
  {
    return $this->validator;
  }

  protected function setClass($class)
  {
    $this->class = $class;
  }

  /**
   * Assigns the validator that will be used with this builder factory instance.
   * All validators have a collection of constraints which are applied against
   * the objects being built, these constraints ensure that the object adheres
   * to a certain valid structure.
   *
   * @param mixed $validator
   */
  protected function setValidator($validator)
  {
    $this->validator = $validator;
  }
}