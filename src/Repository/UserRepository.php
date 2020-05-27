<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function allUsersOrderedByPseudo()
    {
        // $dql = 'SELECT user FROM App\Entity\User user ORDER BY user.pseudo DESC';
        // $query = $this->getEntityManager()->createQuery($dql);

        // dd($query->getSQL()); 

        // return $query->execute();

        $qb = $this->createQueryBuilder('user');
        $qb->addOrderBy('user.pseudo', 'DESC');

        $query = $qb->getQuery(); 

      

    }

    public function search($term)
    {
        return $this->createQueryBuilder('user')
            ->andWhere('sp.sport_name = :term')
            ->leftJoin('user.sports', 'sp')
            ->setParameter('term', '%'.$term.'%')
            ->getQuery()
            ->execute()
            ;
    }


}
