<?php
/* Copyright 2012 Extesla LLC.. All rights reserved.
 *
 * It is illegal to use, reproduce or distribute any part of this
 * Intellectual Property without prior written authorization from
 * Extesla LLC..
 */
namespace Lorecall\UserBundle\Document;

use Lorecall\UserBundle\Model\Achievement as AchievementComplexModel;

/**
 *
 * @author    Sean W. Quinn <sean.quinn@extesla.com>
 * @package   Rhapsody\SocialBundle\Document
 * @copyright Copyright (c) 2015 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class Achievement extends AchievementComplexModel
{
	use \Rhapsody\Commons\Traits\PropertyAwareTrait;
	use \Lorecall\CommonsBundle\Traits\AuditTrait;

	public function __construct()
	{
		parent::__construct();
		$this->achievements = new Doctrine\Common\Collections\ArrayCollection();
	}
}