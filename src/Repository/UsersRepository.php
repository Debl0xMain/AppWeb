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
    public function top10_client($year)
    {
        return $this->createQueryBuilder('u')
            ->select('u.id,u.userName,u.userFristName,u.userRef')
            ->addSelect("SUM(o.OrdPrixTotalHT) as totalAmount")
            ->innerJoin('u.orders', 'o')
            ->where('o.ordDateBill BETWEEN :start_date AND :end_date')
            ->setParameter('start_date', $year.'-01-01')
            ->setParameter('end_date', $year.'-12-31')
            ->groupBy('u.id')
            ->orderBy('totalAmount', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
