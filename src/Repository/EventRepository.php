<?php

namespace App\Repository;

use App\Entity\Event;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\DoctrineExtension;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getUpcomingEvents($limit, $offset)
    {
        $date = new DateTime();

        $qb = $this->createQueryBuilder('e')
            ->where('e.startingDate >= :date')
            ->setParameter('date', $date)
            ->orderBy('e.startingDate', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
        
        return $qb;
    }

    public function getPastEvents($limit, $offset)
    {
        $date = new DateTime();

        $qb = $this->createQueryBuilder('e')
            ->where('e.startingDate >= :date')
            ->setParameter('date', $date)
            ->orderBy('e.startingDate', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();

        return $qb;
    }

    public function getAllDateFromEvents($partygoerId)
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.startingDate')
            ->where('e.planner >= :partygoerId')
            ->setParameter('partygoerId', $partygoerId)
            ->orderBy('e.startingDate', 'DESC')
            ->getQuery()
            ->getResult();

        return $qb;
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
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
    public function findOneBySomeField($value): ?Event
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
