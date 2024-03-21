<?php

namespace App\Repository;

use App\Entity\Adress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @extends ServiceEntityRepository<Adress>
 *
 * @method Adress|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adress|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adress[]    findAll()
 * @method Adress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdressRepository extends ServiceEntityRepository
{
    private $entityManager;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adress::class);
    }

   public function recupinfo($adressId,$userid)
   {
       return $this->createQueryBuilder('a')
           ->select('a.adrNumber','a.adrZipCode','a.adrCity','a.adrAddInfo','a.adrStreet')
           ->join('a.users', 'u')
           ->where('a.id = :adressId')
           ->setParameter('adressId', $adressId)
           ->andwhere('u.id = :userId')
           ->setParameter('userId', $userid)
           ->getQuery()
           ->getResult();
   }
   
}
