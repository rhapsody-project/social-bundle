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
namespace Rhapsody\SocialBundle\Repository\ODM\MongoDB;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Rhapsody\ForumBundle\Model\ForumInterface;
use Rhapsody\SocialBundle\Model\SocialContextInterface;
use Rhapsody\SocialBundle\Repository\TopicRepositoryInterface;

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
class TopicRepository extends DocumentRepository implements TopicRepositoryInterface
{
	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\TopicRepositoryInterface::findOneById()
	 */
	public function findById($id)
	{
		return $this->find($id);
	}

	public function findBySlug($slug)
	{
		return $this->find(array('slug' => $slug));
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\TopicRepositoryInterface::findOneByCategoryAndSlug()
	 */
	public function findOneByCategoryAndSlug($category, $slug)
	{
		return $this->findOneBy(array(
			'slug' => $slug,
			'category.$id' => new \MongoId($category->getId())
		));
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\TopicRepositoryInterface::findOneById()
	 */
	public function findOneById($id)
	{
		return $this->find($id);
	}

	public function findAllByForum(ForumInterface $forum)
	{
		return $this->findAllBySocialContext($forum);
	}

	public function findAllByForumAndCategory(ForumInterface $forum, $category)
	{
		return $this->findAllBySocialContextAndCategory($forum, $category);
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\TopicRepositoryInterface::findAllBySocialContext()
	 */
	public function findAllBySocialContext(SocialContextInterface $socialContext)
	{
		$qb = $this->createQueryBuilder()
			->field('socialContext.$id')->equals(new \MongoId($socialContext->getId()))
			->field('socialContext._doctrine_class_name')->equals(get_class($socialContext))
			->sort('lastUpdated', 'DESC');
		$query = $qb->getQuery();

		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\TopicRepositoryInterface::findAllBySocialContextAndCategory()
	 */
	public function findAllBySocialContextAndCategory(SocialContextInterface $socialContext, $category)
	{
		$qb = $this->createQueryBuilder('t')
			->field('socialContext.$id')->equals(new \MongoId($socialContext->getId()))
			->field('category.$id')->equals(new \MongoId($category->getId()))
			->sort('lastUpdated', 'DESC');
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\TopicRepositoryInterface::findLatestPosted()
	 */
	public function findLatestPosted(SocialContextInterface $socialContext, $number)
	{
		$qb = $this->createQueryBuilder()
			->field('socialContext.$id')->equals(new \MongoId($socialContext->getId()))
			->sort('lastUpdated', 'DESC')
			->limit($number);
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\TopicRepositoryInterface::search()
	 */
	public function search($query)
	{
		$regexp = new \MongoRegex('/' . $query . '/i');
		$qb = $this->createQueryBuilder()
				->field('subject')->equals($regexp)
				->sort('lastUpdated', 'DESC');
		$query = $qb->getQuery();
		return array_values($query->execute()->toArray());
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\PostRepositoryInterface::findAllByTopic()
	 */
	public function getTopicCountBySocialContext($topic)
	{
		$qb = $this->createQueryBuilder()
			->field('socialContext.$id')->equals(new \MongoId($topic->getId()));
		$query = $qb->getQuery();
		return $query->count();
	}

	/**
	 * (non-PHPDoc)
	 * @see \Rhapsody\SocialBundle\Repository\TopicRepositoryInterface::incrementTopicNumViews()
	 */
	public function incrementTopicNumViews($topic)
	{
		$filter = array('_id' => new \MongoId($topic->getId()));
		$expr = array(
			'$inc' => array('viewCount' => 1)
		);

		// ** Perform increment update statement against the tuple.
		$dm = $this->getDocumentManager();
		$dc = $dm->getDocumentCollection($this->getDocumentName());
		$collection = $dc->getMongoCollection();
		$collection->update($filter, $expr);
	}

 	public function updatePostCount($topic, $posts)
 	{
// 		$filter = array('_id' => new \MongoId($topic->getId()));
// 		$expr = array(
// 			'$set' => array('postCount' => $posts)
// 		);
//
// 		// ** Perform increment update statement against the tuple.
// 		$this->getDocumentManager()
// 				->getDocumentCollection($this->getDocumentName())
// 				->getMongoCollection()
// 				->update($filter, $expr);
 	}

 	public function updateReplyCount($topic, $replies)
 	{
// 		$filter = array('_id' => new \MongoId($topic->getId()));
// 		$expr = array(
// 			'$set' => array('replyCount' => $posts)
// 		);
//
// 		// ** Perform increment update statement against the tuple.
// 		$this->getDocumentManager()
// 				->getDocumentCollection($this->getDocumentName())
// 				->getMongoCollection()
// 				->update($filter, $expr);
 	}
}
