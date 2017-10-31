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
 * An Affiliation is a relationship between a <code>User</code> and another
 * entity, usually described in terms of membership to a group or friendship
 * with another user.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class Affiliation implements AffiliationInterface
{

    /**
     * The ID of the affiliation.
     * @var mixed
     */
    protected $id;

    /**
     * Who the user is affiliated with.
     * @var UserInterface
     */
    protected $affiliatedWith;

    /**
     * The date that this affiliation was formed.
     * @var \DateTime
     */
    protected $created;

    /**
     * The user for whom this affiliation is established.
     * @var UserInterface
     */
    protected $user;

    public function __construct()
    {
        $this->created = new \DateTime;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationInterface::getAffiliatedWith()
     */
    public function getAffiliatedWith()
    {
        return $this->affiliatedWith;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationInterface::getCreated()
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationInterface::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the affiliated user.
     *
     * @param UserInterface $affiliatedWith the affiliated user.
     */
    public function setAffiliatedWith(UserInterface $affiliatedWith)
    {
        $this->affiliatedWith = $affiliatedWith;
    }

    /**
     * Set the created date.
     *
     * @param \DateTime $date the created date.
     */
    public function setCreated(\DateTime $date)
    {
        $this->created= $date;
    }

    /**
     * Set the ID.
     *
     * @param mixed $id the affiliation ID.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the user who owns this affiliation.
     *
     * @param UserInterface $user the user who owns this affiliation.
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
    }

}
