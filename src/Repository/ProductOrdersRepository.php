<?php

namespace App\Repository;

use App\Entity\ProductOrders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductOrders>
 *
 * @method ProductOrders|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductOrders|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductOrders[]    findAll()
 * @method ProductOrders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductOrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductOrders::class);
    }

//    /**
//     * @return ProductOrders[] Returns an array of ProductOrders objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductOrders
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
