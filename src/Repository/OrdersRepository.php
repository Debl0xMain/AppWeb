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
        $array = $this->createQueryBuilder('o')
        ->select('sum(o.OrdPrixTotalHT)')
        ->where('o.ordDateBill BETWEEN :start_date AND :end_date')
        ->andWhere('o.ordStatusBill = :status')
        ->setParameter('start_date', $date_d_year)
        ->setParameter('end_date', $date_f_year)
        ->setParameter('status', 2)
        ->getQuery()
        ->getResult();

        return Intval($array[0][1]);
    }

    public function ca_client_pro($date_d_year,$date_f_year)
    {
        return $this->createQueryBuilder('o')
        ->select('sum(o.OrdPrixTotalHT)')
        ->where('o.ordDateBill BETWEEN :start_date AND :end_date')
        ->andWhere('o.ordStatusBill = :status')
        ->innerJoin('o.users','u')
        ->andWhere('u.userCompanySiret IS NOT NULL')
        ->setParameter('start_date', $date_d_year)
        ->setParameter('end_date', $date_f_year)
        ->setParameter('status', 2)
        ->getQuery()
        ->getResult();

        
    }
    public function ca_client_par($date_d_year,$date_f_year)
    {
        return $this->createQueryBuilder('o')
        ->select('sum(o.OrdPrixTotalHT)')
        ->where('o.ordDateBill BETWEEN :start_date AND :end_date')
        ->andWhere('o.ordStatusBill = :status')
        ->innerJoin('o.users','u')
        ->andWhere('u.userCompanySiret IS NULL')
        ->setParameter('start_date', $date_d_year)
        ->setParameter('end_date', $date_f_year)
        ->setParameter('status', 2)
        ->getQuery()
        ->getResult();
    }
}

