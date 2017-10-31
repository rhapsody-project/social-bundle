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
namespace Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rhapsody\SocialBundle\Model\CommentableInterface;
use Rhapsody\SocialBundle\Tests\Functional\Dummy\Bundle\TestBundle\Document\Comment;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author    Sean W. Quinn <sean.quinn@extesla.com>
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity
 * @copyright Rhapsody Project
 * @version   $Id$
 * @since     1.0
 */
abstract class AbstractActivityFixture extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * The reference name for this fixture.
     * @var string
     */
    protected static $referenceName;

    protected function addComments(ObjectManager $manager, CommentableInterface $activity, array $comments = array())
    {
        for ($i = 0; $i < count($comments); $i++) {
            $comment = $comments[$i];
            $activity->addComment($comment);

            $manager->persist($comment);
            $manager->flush();
            $this->addReference(sprintf('%s-comment-%s', static::$referenceName, $i), $comment);
        }
    }

    protected function createComment(UserInterface $user, $text)
    {
        $comment = new Comment();
        $comment->setText($text);
        $comment->setUser($user);

        return $comment;
    }

    /**
     * {@inheritDoc}
     * @see \Doctrine\Common\DataFixtures\OrderedFixtureInterface::getOrder()
     */
    public function getOrder()
    {
        return 8;
    }
}
