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

    /**
     * @return Memos[] Returns an array of UserHistory objects
     */
    public function findUserMemos($userId)
    {
        return $this->createQueryBuilder('m')
            ->select('m.id','m.memo', 'm.created_at', 'm.trash', 'm.title')
            ->where('m.user_id=' . $userId)
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Memos[] Returns an array of UserHistory objects
     */
    public function deleteUserMemos($userId, $memoId)
    {
        $queryString='DELETE FROM App\Entity\Memos m WHERE m.user_id = :userId AND m.id = :memoId ';
        $queryArray=[
            'userId' => $userId,
            'memoId' => $memoId,
        ];
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery($queryString);
        $query->setParameters($queryArray);

        return $query->getResult();
    }

    /**
     * @return Memos[] Returns an array of UserHistory objects
     */
    public function findMemo($memoId)
    {
        $queryString='SELECT m FROM App\Entity\Memos m WHERE m.id = :memoId ';
        $queryArray=[
            'memoId' => $memoId,
        ];
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery($queryString);
        $query->setParameters($queryArray);

        return $query->getResult();
    }

    /**
     * @return Memos[] Returns an array of UserHistory objects
     */
    public function editUserMemo($memoId, $title, $memo)
    {
        $queryString='UPDATE m SET m.title = :title ,m.memo = :memo WHERE m.id = :memoId ';
        $queryArray=[
            'memoId' => $memoId,
            'title' => $title,
            'memo' => $memo,
        ];
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery($queryString);
        $query->setParameters($queryArray);

        return $query->getResult();
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