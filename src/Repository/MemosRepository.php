<?php

namespace App\Repository;

use App\Entity\Memos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Memos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Memos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Memos[]    findAll()
 * @method Memos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Memos::class);
    }

    // /**
    //  * @return Memos[] Returns an array of Memos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Memos
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
