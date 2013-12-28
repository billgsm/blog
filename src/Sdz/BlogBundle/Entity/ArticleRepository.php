<?php

namespace Sdz\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    public function getByCategory(array $categories_names)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->join('a.categories', 'c')
           ->where($qb->expr()->in('c.name', $categories_names));

        return $qb->getQuery()
                  ->getResult();
    }
}
