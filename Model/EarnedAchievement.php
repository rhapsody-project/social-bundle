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
namespace Rhapsody\SocialBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The relationship between a user and an achievement.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class EarnedAchievement extends Content implements EarnedAchievementInterface
{

    /**
     * The object ID of the earned achievement.
     * @var mixed
     */
    protected $id;

    /**
     * The achievement earned.
     * @var AchievementInterface
     */
    protected $achievement;

    /**
     * When the achievement was earned.
     * @var \DateTime
     */
    protected $date;

    /**
     * The user who earned the achievement.
     * @var UserInterface
     */
    protected $user;

    public function __construct()
    {
        $this->date = new \DateTime;
    }

    public function getAchievement()
    {
        return $this->achievement;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setAchievement(AchievementInterface $achievement)
    {
        $this->achievement = $achievement;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }
}