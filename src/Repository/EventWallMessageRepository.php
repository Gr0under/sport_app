<?php

namespace App\Repository;

use App\Entity\EventWallMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventWallMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventWallMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventWallMessage[]    findAll()
 * @method EventWallMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventWallMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventWallMessage::class);
    }

    // /**
    //  * @return EventWallMessage[] Returns an array of EventWallMessage objects
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
    public function findOneBySomeField($value): ?EventWallMessage
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
