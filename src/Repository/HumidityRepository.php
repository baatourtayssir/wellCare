<?php

namespace App\Repository;

use App\Entity\Humidity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Humidity>
 *
 * @method Humidity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Humidity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Humidity[]    findAll()
 * @method Humidity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HumidityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Humidity::class);
    }

//    /**
//     * @return Humidity[] Returns an array of Humidity objects
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

//    public function findOneBySomeField($value): ?Humidity
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
