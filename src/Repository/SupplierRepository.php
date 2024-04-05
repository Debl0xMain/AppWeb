<?php

namespace App\Repository;

use App\Entity\Supplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Supplier>
 *
 * @method Supplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplier[]    findAll()
 * @method Supplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

   public function ca_supplier($year): array
   {
    return $this->createQueryBuilder('s')
    ->select('s.supRef, s.supName, SUM(po.price_ligneht) as ca_supplier')
    ->join('s.products', 'p')
    ->join('p.productOrders', 'po')
    ->join('po.orders' , 'o')
    ->where('o.ordDateBill BETWEEN :start_date AND :end_date')
    ->andWhere('o.ordStatusBill = :status')
    ->setParameter('start_date', $year.'-01-01')
    ->setParameter('end_date', $year.'-12-31')
    ->setParameter('status', 2)
    ->groupBy('s.id')
    ->orderBy('ca_supplier', 'DESC')
    ->getQuery()
    ->getResult();
   }

}
