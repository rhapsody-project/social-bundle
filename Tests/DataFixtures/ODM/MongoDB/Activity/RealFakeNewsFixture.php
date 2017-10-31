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
use Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\MarkZuckerbergFixture;
use Rhapsody\SocialBundle\Tests\Functional\Dummy\Bundle\TestBundle\Document\Activity;

/**
 * Say what you will about fake news, it seems to be everywhere these days. As
 * such, a news feed would be incomplete without some.
 *
 * @author    Sean W. Quinn <sean.quinn@extesla.com>
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Activity
 * @copyright Rhapsody Project
 * @version   $Id$
 * @since     1.0
 */
class RealFakeNewsFixture extends AbstractActivityFixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $user = $this->getReference('user-mzuckerberg');

        $date = new \DateTime('2016-03-27 23:47:12');

        $activity = new Activity();
        $activity->setCreated($date);
        $activity->setLastModified($date);
        $activity->setText('Trust us. We\'re legitimate.');
        $activity->setUser($user);

        $manager->persist($activity);
        $manager->flush();
        $this->addReference('activity-mzuckerberg-realfakenews', $activity);
    }

    /**
     * {@inheritDoc}
     * @see \Doctrine\Common\DataFixtures\DependentFixtureInterface::getDependencies()
     */
    public function getDependencies()
    {
        return array(
            MarkZuckerbergFixture::class
        );
    }

}
