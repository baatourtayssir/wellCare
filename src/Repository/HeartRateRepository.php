<?php

namespace App\Repository;

use App\Entity\HeartRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HeartRate>
 *
 * @method HeartRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method HeartRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method HeartRate[]    findAll()
 * @method HeartRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeartRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HeartRate::class);
    }

//    /**
//     * @return HeartRate[] Returns an array of HeartRate objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HeartRate
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
