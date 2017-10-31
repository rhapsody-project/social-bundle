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
 * An endorsement of an object.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class Endorsement implements EndorsementInterface
{

    /**
     * The endorsement's ID.
     * @var mixed
     */
    protected $id;

    /**
     * The date of the endorsement.
     * @var \DateTime
     */
    protected $date;

    /**
     * The endorsed record.
     * @var EndorsableInterface
     */
    protected $endorsed;

    /**
     * The user behind this endorsement.
     * @var mixed
     */
    protected $user;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\EndorsementInterface::getDate()
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\EndorsementInterface::getEndorsed()
     */
    public function getEndorsed()
    {
        return $this->endorsed;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\EndorsementInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\EndorsementInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the date of this endorsement.
     *
     * @param \DateTime $date the date of this endorsement.
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Set the endorsed record.
     *
     * @param EndorsableInterface $endorsed the endorsed record.
     */
    public function setEndorsed(EndorsableInterface $endorsed)
    {
        $this->endorsed = $endorsed;
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
     * Set the user responsible for the endorsement.
     *
     * @param UserInterface $user the user responsible for the endorsement.
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

}