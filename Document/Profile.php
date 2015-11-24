<?php
/* Copyright 2012 Extesla LLC.. All rights reserved.
 *
 * It is illegal to use, reproduce or distribute any part of this
 * Intellectual Property without prior written authorization from
 * Extesla LLC..
 */
namespace Rhapsody\SocialBundle\Document;

use Rhapsody\SocialBundle\Model\Profile as ProfileModel;
use Rhapsody\SocialBundle\Model\ActivitySourceInterface;

/**
 *
 * @author    Sean W. Quinn <sean.quinn@extesla.com>
 * @package   Rhapsody\SocialBundle\Document
 * @copyright Copyright (c) 2015 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Profile extends ProfileModel
{
	use \Rhapsody\Commons\Traits\ObjectTrait;
	use \Rhapsody\Commons\Traits\PropertyAwareTrait;

	public function __construct()
	{
		parent::__construct();
		$this->following = new \Doctrine\Common\Collections\ArrayCollection;
	}

	public function follow(ActivitySourceInterface $subject)
	{
		if (!$this->isFollowing($subject)) {
			$this->following->add($subject);
		}
	}
}