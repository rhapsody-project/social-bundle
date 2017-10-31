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
namespace Rhapsody\SocialBundle\Validator\Constraint;

use Rhapsody\SocialBundle\Model\SocialContextAwareInterface;
use Rhapsody\SocialBundle\Model\SocialContextInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Validator\Constraint
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class SocialContextConstraint implements Constraint
{

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Validator\Constraint\Constraint::evaluate()
     */
    public function evaluate($object)
    {
        if (!$object instanceof SocialContextAwareInterface) {
            throw new \InvalidArgumentException(sprintf('The object defined by: %s was not an instance of the SocialContextAwareInterface. Failing because: Unable to evaluate for the existence of a forum.', get_class($object)));
        }

        $forum = $object->getSocialContext();
        if ($forum === null) {
            throw new \InvalidArgumentException(sprintf('SocialContext property was NULL. SocialContext is required for %s.', get_class($object)));
        }

        if (!$forum instanceof SocialContextInterface) {
            throw new \Exception(sprintf('Invalid type assigned to forum property. Value assigned is type of: %s, expected: SocialContextInterface', get_class($forum)));
        }
    }
}
