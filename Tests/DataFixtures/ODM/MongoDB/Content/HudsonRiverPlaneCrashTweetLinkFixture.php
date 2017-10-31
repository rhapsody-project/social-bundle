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
namespace Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Content;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Rhapsody\SocialBundle\Tests\Functional\Dummy\Bundle\TestBundle\Document\Link;

/**
 * When a plane came crashing down in New York and the pilot executed a
 * difficult, yet masterful, landing on the Hudson--Twitter was there to capture
 * it.
 *
 * @author    Sean W. Quinn <sean.quinn@extesla.com>
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Tests\DataFixtures\ODM\MongoDB\Content
 * @copyright Rhapsody Project
 * @version   $Id$
 * @since     1.0
 */
class HudsonRiverPlaneCrashTweetLinkFixture extends AbstractContentFixture
{

    public function load(ObjectManager $manager)
    {
        $link = new Link();
        $link->setUrl('http://tweets.io/nycguy/hudson-rive-plane-crash');
        $link->setType('tweet');
        $link->setSummary('@nyc did you just see that? A plane crashed into the Hudson!');

        $manager->persist($link);
        $manager->flush();
        $this->addReference('content-link-hudsonriverplanecrashtweet', $link);
    }

}
