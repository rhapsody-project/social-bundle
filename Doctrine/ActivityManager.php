<?php
/* Copyright (c) 2013 Rhapsody Project
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
namespace Rhapsody\SocialBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Rhapsody\SocialBundle\Model\ActivityInterface;

/**
 * A basic inplementation of the activity manager; this can be extended.
 *
 * @author Sean.Quinn
 * @since 1.0
 */
class ActivityManager
{
	/**
	 *
	 * @var $objectManager \Doctrine\Common\Persistence\ObjectManager
	 */
	protected $objectManager;

	/**
	 *
	 * @var $class string
	 */
	protected $class;

	/**
	 * @var \Doctrine\Common\Persistence\ObjectRepository
	 */
	protected $repository;

	/**
	 * Constructor.
	 *
	 * @param EncoderFactoryInterface $encoderFactory
	 * @param CanonicalizerInterface  $usernameCanonicalizer
	 * @param CanonicalizerInterface  $emailCanonicalizer
	 * @param ObjectManager           $om
	 * @param string                  $class
	 */
	public function __construct(ObjectManager $objectManager, $class)
	{
		$this->objectManager = $objectManager;
		$this->repository = $objectManager->getRepository($class);

		$metadata = $objectManager->getClassMetadata($class);
		$this->class = $metadata->getName();
	}

	public function findActivityBy(array $criteria = array())
	{
		return $this->repository->findOneBy($criteria);
	}

	public function findAllActivityBy(array $criteria = array())
	{
		return $this->repository->findBy($criteria);
	}

	/**
	 * Removes an activity from a user's activity feed. If an activity is
	 * removed that references another object, e.g. a blog post, that post will
	 * not be removed. In order to remove objects associated with an activity
	 * the user must appropriately manage that content elsewhere.
	 *
	 * @param ActivityInterface $activity
	 */
	public function deleteActivity(ActivityInterface $activity)
	{
		$this->objectManager->remove($activity);
		$this->objectManager->flush();
	}

	public function updateActivity(ActivityInterface $activity, $andFlush = true)
	{
		$this->objectManager->persist($activity);
		if ($andFlush) {
			$this->objectManager->flush();
		}
	}
}