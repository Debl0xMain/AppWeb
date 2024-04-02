<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Orders>
 *
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    public function find_id($date_d_year,$date_f_year)
    {
        return $this->createQueryBuilder('o')
        ->select('SUM(o.ordPrixTotal) AS Prix_TTC')
        ->addSelect('SUM(o.OrdPrixTotalHT) AS Prix_HT')
        ->addSelect('SUM(o.ordPrixTotal - o.OrdPrixTotalHT) AS tva')
        ->where('o.ordDateBill BETWEEN :start_date AND :end_date')
        ->andWhere('o.ordStatusBill = :status')
        ->setParameter('start_date', $date_d_year)
        ->setParameter('end_date', $date_f_year)
        ->setParameter('status', 2)
        ->getQuery()
        ->getResult();
    }
}

