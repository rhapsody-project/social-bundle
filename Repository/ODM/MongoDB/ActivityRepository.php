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
namespace Rhapsody\SocialBundle\Repository\ODM\MongoDB;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Rhapsody\SocialBundle\Repository\ActivityRepositoryInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody ForumBundle
 * @package   Rhapsody\ForumBundle\Repository\ODM\MongoDB
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityRepository extends DocumentRepository implements ActivityRepositoryInterface
{
	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\ActivityRepositoryInterface::findAllBySource()
	 */
	public function findAllBySource($sources = array(), $date = null, $limit = 50)
	{
		$qb = $this->createQueryBuilder()->limit($limit)->sort('date', 'DESC');

		// ** Apply date filter.
		if (!empty($date)) {
			$qb->field('date')->lte($date);
		}

		// ** Apply source filters.
		$qb->addOr($qb->expr()->field('source')->exists(false));
		foreach ($sources as $source) {
			$expr = $qb->expr() //->field('source')->equals($source);
				->field('source.$id')->equals(new \MongoId($source->getId()))
				->field('source._doctrine_class_name')->equals(get_class($source));
			$qb->addOr($expr);
		}
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	public function findAllByUserAndDate($user, $date, $limit = 50)
	{
		$qb = $this->createQueryBuilder()
			->field('source')->equals($user)
			->limit($limit)
			->sort('date', 'DESC');
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\ActivityRepositoryInterface::findOneById()
	 */
	public function findOneById($id)
	{
		return $this->find($id);
	}
}
