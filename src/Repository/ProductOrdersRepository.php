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


   public function top10_quantity($year)
   {
    return $this->createQueryBuilder('po')
    ->Select('SUM(po.pro_ordProductQuantity) as quantite')
    ->addSelect('p.proName')
    ->join('po.orders', 'o')
    ->join('po.product', 'p')
    ->where('o.ordDateBill BETWEEN :start_date AND :end_date')
    ->setParameter('start_date', $year.'-01-01')
    ->setParameter('end_date', $year.'-12-31')
    ->groupBy('p.id')
    ->orderBy('quantite', 'DESC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult();
   }

   public function top10_price($year)
   {
    return $this->createQueryBuilder('po')
    ->select('COUNT(p.id) AS nombre_idcount')
    ->addSelect('COUNT(po.pro_ordProductQuantity) as nombre_quantity')
    ->addSelect('SUM(po.price_ligneht) as resultat_price')
    ->addSelect('p.id')
    ->addSelect('p.proName')
    ->join('po.orders', 'o')
    ->join('po.product', 'p')
    ->where('o.ordDateBill BETWEEN :start_date AND :end_date')
    ->setParameter('start_date', $year.'-01-01')
    ->setParameter('end_date', $year.'-12-31')
    ->groupBy('p.id')
    ->orderBy('resultat_price', 'DESC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult();
   }
}
