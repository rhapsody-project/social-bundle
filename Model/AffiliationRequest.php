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
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Model
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class AffiliationRequest implements AffiliationRequestInterface
{

    /**
     * The ID of this affiliation request.
     * @var mixed
     */
    protected $id;

    /**
     * When the affiliation request was accepted.
     * @var \DateTime
     */
    protected $acceptedOn;

    /**
     * When the affiliation request was created.
     * @var \DateTime
     */
    protected $created;

    /**
     * When the affiliation request expires.
     * @var \DateTime
     */
    protected $expiresAt;

    /**
     * The recipient of the affiliation request.
     * @var UserInterface
     */
    protected $recipient;

    /**
     * The user who made the affiliation request.
     * @var UserInterface
     */
    protected $requestedBy;

    public function __construct()
    {
        $this->created = new \DateTime;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationRequestInterface::getAcceptedOn()
     */
    public function getAcceptedOn()
    {
        return $this->acceptedOn;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationRequestInterface::getCreated()
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationRequestInterface::getExpiresAt()
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationRequestInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationRequestInterface::getRecipient()
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationRequestInterface::getRequestedBy()
     */
    public function getRequestedBy()
    {
        return $this->requestedBy;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationRequestInterface::isAccepted()
     */
    public function isAccepted()
    {
        return null !== $this->acceptedOn;
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Model\AffiliationRequestInterface::isExpired()
     */
    public function isExpired()
    {
        if (null !== $this->expiresAt) {
            $now = new \DateTime();
            if ($this->expiresAt <= $now) {
                return true;
            }
        }
        return false;
    }

    /**
     * Set the date that this affiliation request was accepted.
     *
     * @param \DateTime $date the date that this affiliation request was
     *     accepted.
     */
    public function setAcceptedOn(\DateTime $date)
    {
        $this->acceptedOn = $date;
    }

    /**
     * Set the date that this affiliation request was created.
     *
     * @param \DateTime $date the date that this affiliation request was
     *     created.
     */
    public function setCreated(\DateTime $date)
    {
        $this->created = $date;
    }

    /**
     * Set the date that this affiliation request expires.
     *
     * @param \DateTime $date the date that this affiliation request expires.
     */
    public function setExpiresAt(\DateTime $date)
    {
        $this->expiresAt = $date;
    }

    /**
     * Set the ID of this affiliation request.
     *
     * @param mixed $id the ID of the affiliation request.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the recipient of this this affiliation request.
     *
     * @param UserInterface $recipient the recipient of the affiliation request.
     */
    public function setRecipient(UserInterface $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Set the user who made the request.
     *
     * @param UserInterface $requestedBy the user who made the request.
     */
    public function setRequestedBy(UserInterface $requestedBy)
    {
        $this->requestedBy = $requestedBy;
    }

}