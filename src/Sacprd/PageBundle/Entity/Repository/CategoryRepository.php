<?php

namespace Sacprd\PageBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function getByPage($entity, $offset = 0, $limit = 50)
    {
        $res = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('p')
            ->from($entity, 'p')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    
        return $res;
    }
}
