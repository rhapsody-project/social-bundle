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

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\JackDorseyFixture;
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Content\RoyalWeddingAnnouncementLinkFixture;
use Rhapsody\SocialBundle\Tests\Functional\Dummy\Bundle\TestBundle\Document\Activity;

/**
 * Who broke the royal wedding announcement first? Twitter. That's who.
 *
 * @author    Sean W. Quinn <sean.quinn@extesla.com>
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity
 * @copyright Rhapsody Project
 * @version   $Id$
 * @since     1.0
 */
class RoyalWeddingAnnouncementFixture extends AbstractActivityFixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $user = $this->getReference('user-jdorsey');
        $content = $this->getReference('content-link-royalweddingannouncement');

        $date = new \DateTime('2010-11-16 09:30:00');

        $activity = new Activity();
        $activity->setCreated($date);
        $activity->setLastModified($date);
        $activity->setText('The new Mr. and Mrs. Royal.');
        $activity->setContent($content);
        $activity->setUser($user);

        $manager->persist($activity);
        $manager->flush();
        $this->addReference('activity-jdorsey-royalweddingannouncement', $activity);
    }

    /**
     * {@inheritDoc}
     * @see \Doctrine\Common\DataFixtures\DependentFixtureInterface::getDependencies()
     */
    public function getDependencies()
    {
        return array(
            JackDorseyFixture::class,
            RoyalWeddingAnnouncementLinkFixture::class
        );
    }

}
