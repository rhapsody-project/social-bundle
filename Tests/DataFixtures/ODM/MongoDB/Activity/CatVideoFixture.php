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
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\TomAndersonFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Content\CatVideoLinkFixture;
use Rhapsody\SocialBundle\Tests\Functional\Dummy\Bundle\TestBundle\Document\Activity;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\JackDorseyFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\MarkZuckerbergFixture;

/**
 * Cat videos rule the internet. It wouldn't be a news feed without cat videos
 * somewhere in the mix.
 *
 * @author    Sean W. Quinn <sean.quinn@extesla.com>
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity
 * @copyright Rhapsody Project
 * @version   $Id$
 * @since     1.0
 */
class CatVideoFixture extends AbstractActivityFixture implements DependentFixtureInterface
{
    /** @{inheritdoc} */
    protected static $referenceName = 'activity-tanderson-catvideo';

    public function load(ObjectManager $manager)
    {
        $jdorsey = $this->getReference('user-jdorsey');
        $mzuckerberg = $this->getReference('user-mzuckerberg');
        $tanderson = $this->getReference('user-tanderson');
        $content = $this->getReference('content-link-catvideo');

        $date = new \DateTime('2008-10-25 18:30:00');
        $activity = new Activity();
        $activity->setCreated($date);
        $activity->setLastModified($date);
        $activity->setText('Funny cat video!');
        $activity->setContent($content);
        $activity->setUser($tanderson);

        $comments[] = $this->createComment($tanderson, 'Soooo funny! Lol');
        $comments[] = $this->createComment($jdorsey, 'Look at the fur devil!');
        $comments[] = $this->createComment($jdorsey, 'How does he react to cucumbers?');
        $comments[] = $this->createComment($mzuckerberg, 'First!');
        $comments[] = $this->createComment($tanderson, 'Wrong-o @mzuckerberg!');
        $this->addComments($manager, $activity, $comments);

        $manager->persist($activity);
        $manager->flush();
        $this->addReference(sprintf('%s', static::$referenceName), $activity);
    }

    /**
     * {@inheritDoc}
     * @see \Doctrine\Common\DataFixtures\DependentFixtureInterface::getDependencies()
     */
    public function getDependencies()
    {
        return array(
            JackDorseyFixture::class,
            MarkZuckerbergFixture::class,
            TomAndersonFixture::class,
            CatVideoLinkFixture::class
        );
    }

}
