<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Partygoer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findAllCommentsOnMyParties(Partygoer $partygoer)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.event', 'e')
            ->andWhere('e.planner = :val')
            ->setParameter('val', $partygoer->getId())
            ->orderBy('c.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllEventRelatedToComment(Partygoer $partygoer)
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.event', 'e')
            ->where('e.planner = :partygoerId')
            ->setParameter('partygoerId', $partygoer->getId())
            ->getQuery()
            ->getResult();
        
        return $qb;
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
