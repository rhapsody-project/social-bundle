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
namespace Rhapsody\SocialBundle\Repository\ODM\MongoDB;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Rhapsody\SocialBundle\Model\ActivitySourceInterface;
use Rhapsody\SocialBundle\Repository\ActivityRepositoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Repository\ODM\MongoDB
 * @copyright Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivityRepository extends DocumentRepository implements ActivityRepositoryInterface
{

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Repository\ActivityRepositoryInterface::findByActivitySource()
     */
    public function findByActivitySource(ActivitySourceInterface $activitySource, $limit = null, $offset = 0)
    {
        $sourceId = $this->getReferenceForActivitySource($activitySource);

        $qb = $this->createQueryBuilder()
            ->field('source.$id')->equals($sourceId)
            ->field('source._doctrine_class_name')->equals(ClassUtils::getClass($activitySource))
            ->sort('created', 'DESC')
        ;

        if (null !== $limit) {
            $qb->limit($limit);
        }
        if ($offset > 0) {
            $qb->skip($offset);
        }

        $query = $qb->getQuery();
        $results = $query->execute()->toArray();
        return array_values($results);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Repository\ActivityRepositoryInterface::findByUserAndDate()
     */
    public function findByUserAndDate($user, \DateTime $start = null, \DateTime $end = null, $limit = null, $offset = 0)
    {
        $qb = $this->createQueryBuilder()->sort('created', 'desc');
        $qb->addAnd($qb->expr()->field('created')->gte($start));
        $qb->addAnd($qb->expr()->field('created')->lte($end));

        if (null !== $limit) {
            $qb->limit($limit);
        }
        if ($offset > 0) {
            $qb->skip($offset);
        }

        $query = $qb->getQuery();
        $results = $query->execute()->toArray();
        return array_values($results);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Repository\ActivityRepositoryInterface::findByUser()
     */
    public function findByUser($user, $limit = null, $offset = 0)
    {
        $userId = $this->getReferenceForUser($user);

        $qb = $this->createQueryBuilder()
            ->field('user.$id')->equals($userId)
            ->sort('created', 'DESC')
        ;

        if (null !== $limit) {
            $qb->limit($limit);
        }
        if ($offset > 0) {
            $qb->skip($offset);
        }

        $query = $qb->getQuery();
        $results = $query->execute()->toArray();
        return array_values($results);
    }

    /**
     * {@inheritDoc}
     * @see \Rhapsody\SocialBundle\Repository\ActivityRepositoryInterface::findOneById()
     */
    public function findOneById($id)
    {
        return $this->findOneBy(array(
            'id' => new \MongoId($id)
        ));
    }

    private function getReferenceForActivitySource($activitySource)
    {
        if ($activitySource instanceof ActivitySourceInterface) {
            return new \MongoId($activitySource->getId());
        }
        return new \MongoId($activitySource);
    }

    private function getReferenceForUser($user)
    {
        if ($user instanceof UserInterface) {
            return new \MongoId($user->getId());
        }
        return new \MongoId($user);
    }
}
