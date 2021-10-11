<?php

namespace App\Repository;

use App\Entity\EventPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventPicture[]    findAll()
 * @method EventPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventPicture::class);
    }

    // /**
    //  * @return EventPicture[] Returns an array of EventPicture objects
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
    public function findOneBySomeField($value): ?EventPicture
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
