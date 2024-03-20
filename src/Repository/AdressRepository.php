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

   public function AdressUser($userId)
   {
       return $this->createQueryBuilder('a')
           ->select('a.adrNumber','a.adrZipCode','a.adrCity','a.adrAddInfo','a.adrStreet', 'u.id')
           ->join('a.users', 'u')
           ->where('u.id = :userId')
           ->setParameter('userId', $userId)
           ->getQuery()
           ->getResult();
   }
   public function AssemblyAdress($recup_adress)
   {
        $lenght_table = count($recup_adress);
        $table_adress_select = [];


        for ($i = 0; $i < $lenght_table; $i++) {

            $compresion_adress = $recup_adress[$i]['adrNumber'].' '.$recup_adress[$i]['adrStreet'].' '.$recup_adress[$i]['adrCity'].' '.$recup_adress[$i]['adrZipCode'];
            $test = strval($compresion_adress);
            array_push($table_adress_select,$test);
        }
        
        return $table_adress_select;
   }
}
