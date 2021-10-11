<?php

namespace App\Repository;

use App\Entity\EventCover;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventCover|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventCover|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventCover[]    findAll()
 * @method EventCover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventCoverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventCover::class);
    }

    // /**
    //  * @return EventCover[] Returns an array of EventCover objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventCover
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
