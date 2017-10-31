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
 *
 * @author Sean.Quinn
 */
abstract class Share implements ShareInterface
{

    /**
     * The share's ID.
     * @var mixed
     */
    protected $id;

    /**
     * The date of the share.
     * @var \DateTime
     */
    protected $date;

    /**
     * The shared record.
     * @var ShareableInterface
     */
    protected $shared;

    /**
     * The user responsible for sharing.
     * @var mixed
     */
    protected $user;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ShareInterface::getDate()
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ShareInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ShareInterface::getShared()
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\ShareInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the date of this share.
     *
     * @param \DateTime $date the date of this share.
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Set the endorsement's ID.
     *
     * @param mixed $id the endorsement's ID.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the shared record.
     *
     * @param ShareableInterface $shared the shared record.
     */
    public function setShared(ShareableInterface $shared)
    {
        $this->shared = $shared;
    }

    /**
     * Set the user responsible for sharing.
     *
     * @param UserInterface $user the user responsible for sharing.
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }
}