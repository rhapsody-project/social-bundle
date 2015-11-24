<?php
/* Copyright (c) 2015 Rhapsody Project
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
namespace Rhapsody\SocialBundle\Doctrine\ODM\MongoDB;

use Doctrine\Common\Persistence\ObjectManager;
use Monolog\Logger;
use Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface;
use Rhapsody\SocialBundle\Factory\BuilderFactoryInterface;
use Rhapsody\SocialBundle\Model\ActivityInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * A basic inplementation of the activity manager; this can be extended.
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Doctrine\ODM\MongoDB
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityManager implements ActivityManagerInterface
{
	/**
	 * Whether or not to automatically flush changes after a persistence
	 * operation is performed.
	 * @var boolean
	 * @access protected
	 */
	protected $autoFlush = true;

	/**
	 * The logging device.
	 * @var \Monolog\Logger
	 * @access protected
	 */
	protected $logger;

	/**
	 * The event dispatcher.
	 * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
	 * @access protected
	 */
	protected $eventDispatcher;

	/**
	 * The object manager.
	 * @var \Doctrine\Common\Persistence\ObjectManager
	 * @access protected
	 */
	protected $objectManager;

	/**
	 * The repository.
	 * @var \Doctrine\ODM\MongoDB\DocumentRepository
	 * @access protected
	 */
	protected $repository;

	/**
	 * The class builder factory.
	 * @var \Rhapsody\SocialBundle\Factory\BuilderFactoryInterface
	 * @access protected
	 */
	protected $builderFactory;

	/**
	 * The class.
	 * @var string
	 * @access protected
	 */
	protected $class;

	/**
	 * Constructor.
	 *
	 * @param EncoderFactoryInterface $encoderFactory
	 * @param CanonicalizerInterface  $usernameCanonicalizer
	 * @param CanonicalizerInterface  $emailCanonicalizer
	 * @param ObjectManager           $om
	 * @param string                  $class
	 */
	public function __construct(ObjectManager $objectManager, EventDispatcherInterface $eventDispatcher, BuilderFactoryInterface $builderFactory, $class)
	{
		$repository = $objectManager->getRepository($class);
		$metadata = $objectManager->getClassMetadata($class);

		$this->class = $metadata->getName();
		$this->repository = $repository;
		$this->eventDispatcher = $eventDispatcher;
		$this->objectManager = $objectManager;
		$this->builderFactory = $builderFactory;

		$this->logger = new Logger(get_class($this));
	}

	/**
	 * (non-PHPDoc)
	 * @see Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface::createActivityBuilder()
	 */
	public function createActivityBuilder()
	{
		return $this->builderFactory->createBuilder();
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
	 * {@inheritDoc}
	 * @see \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface::findActivityBySource()
	 */
	public function findActivityBySource($sources = array(), $date = null, $limit = 50)
	{
		if (empty($date)) {
			$date = new \DateTime;
		}
		return $this->repository->findAllBySource($sources, $date, $limit);
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

	public function newActivity($args = array())
	{
		$builder = $this->createActivityBuilder();

		if (array_key_exists('author', $args) && $args['author'] !== null) {
			$builder->setAuthor($args['author']);
		}

		if (array_key_exists('date', $args) && $args['date'] !== null) {
			$builder->setDate($args['date']);
		}

		if (array_key_exists('content', $args) && $args['content'] !== null) {
			$builder->setContent($args['content']);
		}

		if (array_key_exists('source', $args) && $args['source'] !== null) {
			$builder->setSource($args['source']);
		}

		if (array_key_exists('text', $args) && $args['text'] !== null) {
			$builder->setText($args['text']);
		}

		if (array_key_exists('user', $args) && $args['user'] !== null) {
			$builder->setUser($args['user']);
		}
		return $builder->build();
	}

	public function updateActivity(ActivityInterface $activity, $andFlush = true)
	{
		$this->objectManager->persist($activity);
		if ($andFlush) {
			$this->objectManager->flush();
		}
	}
}
