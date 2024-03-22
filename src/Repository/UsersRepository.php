<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\Orders;
use App\Entity\Delivery;
use App\Entity\productOrders;
use App\Entity\productDelivery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $entityManager;
    public function __construct(ManagerRegistry $registry,EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Users::class);
        $this->entityManager = $entityManager;
        
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
    // public function histo_cmd($userId)
    // {
    //     return $this->createQueryBuilder('u')
    //     ->select('o.ordRef', 'o.ordReduction', 'o.ordAdressDelivery', 'o.ordAdressBilling', 'o.ordStatusBill', 'o.ordPrixTotal', 'd.delDateExped', 'd.delDatePlannedDelivery', 'd.delDateDeliveryClient', 'po.pro_ordNameProduct', 'po.pro_ordProductQuantity', 'po.pro_ordPriceUht', 'u.userCoefficient')
    //     // ->Join(Users::class, 'u')
    //     ->join(Orders::class, 'o')
    //     ->join(delivery::class, 'd')
    //     ->join(productOrders::class, 'po')
    //     ->join(productDelivery::class, 'pd')
    //     ->where('u.id = :userId')
    //     ->setParameter('userId', $userId)
    //     ->getQuery()
    //     ->getResult();
    // }
}
