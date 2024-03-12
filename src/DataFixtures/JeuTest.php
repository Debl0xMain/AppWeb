<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;
use App\Entity\Adress;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class JeuTest extends Fixture
{
    //Function
    private $hasher;
            
    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }
    //Data
    public function load(ObjectManager $manager): void
    {
        //Varibale :

            $coeficient_base = 1.8;
        
        //Users Commercial

            //1 possede 2 particulier

            $comuser1 = new Users();
            $comuser1->setUserEmail('commercial1@example.com');
            $comuser1->setRoles(['ROLE_USER']);
            $comuser1->setPassword($this->hasher->hashPassword($comuser1, 'admin'));
            $comuser1->setUserName('TestUser1');
            $comuser1->setUserFristName('Brian');
            $comuser1->setUserRef('combria8457');
            $comuser1->setUserPhone('123456789');
            $comuser1->setUserCoefficient($coeficient_base);

            $manager->persist($comuser1);

            //2 posede 2 professionel

            $comuser2 = new Users();
            $comuser2->setUserEmail('comercial2@example.com');
            $comuser2->setRoles(['ROLE_USER']);
            $comuser2->setPassword($this->hasher->hashPassword($comuser2, 'admin'));
            $comuser2->setUserName('TestUser2');
            $comuser2->setUserFristName('Bastian');
            $comuser2->setUserRef('combas8452');
            $comuser2->setUserPhone('123456789');
            $comuser2->setUserCoefficient($coeficient_base);

            $manager->persist($comuser2);

            //3 possede 1 pro 1 particulier

            $comuser3 = new Users();
            $comuser3->setUserEmail('commercial3@example.com');
            $comuser3->setRoles(['ROLE_USER']);
            $comuser3->setPassword($this->hasher->hashPassword($comuser3, 'admin'));
            $comuser3->setUserName('TestUser3');
            $comuser3->setUserFristName('Zoé');
            $comuser3->setUserRef('comzoe8452');
            $comuser3->setUserPhone('123456789');
            $comuser3->setUserCoefficient($coeficient_base);

            $manager->persist($comuser3);

        //Users Particulier

            //1

            $user1 = new Users();
            $user1->setUserEmail('particulier1@example.com');
            $user1->setRoles(['ROLE_USER']);
            $user1->setPassword($this->hasher->hashPassword($user1, 'admin'));
            $user1->setUserName('TestUser1');
            $user1->setUserFristName('John');
            $user1->setUserRef('clijohn1486');
            $user1->setUserPhone('123456789');
            $user1->setUserCoefficient($coeficient_base);
            $user1->setCommercialRef($comuser1);

            $manager->persist($user1);

                //adress

                $adress1 = new Adress();
                $adress1->setAdrNumber('123');
                $adress1->setAdrStreet('Main Street');
                $adress1->setAdrZipCode('12345');
                $adress1->setAdrCity('Cityville');
                $adress1->setAdrAddInfo('2eme etage');
                $adress1->addUser($user1);
        
                $manager->persist($adress1);

            //2

            $user2 = new Users();
            $user2->setUserEmail('particulier2@example.com');
            $user2->setRoles(['ROLE_USER']);
            $user2->setPassword($this->hasher->hashPassword($user2, 'admin'));
            $user2->setUserName('TestUser2');
            $user2->setUserFristName('Kim');
            $user2->setUserRef('clikim1524');
            $user2->setUserPhone('123456789');
            $user2->setUserCoefficient($coeficient_base);
            $user2->setCommercialRef($comuser1);

            $manager->persist($user2);

                //adress

                $adress2 = new Adress();
                $adress2->setAdrNumber('24');
                $adress2->setAdrStreet('rue pierre');
                $adress2->setAdrZipCode('80514');
                $adress2->setAdrCity('Villetest');
                $adress2->addUser($user2);
        
                $manager->persist($adress2);

            //3

            $user3 = new Users();
            $user3->setUserEmail('particulier3@example.com');
            $user3->setRoles(['ROLE_USER']);
            $user3->setPassword($this->hasher->hashPassword($user3, 'admin'));
            $user3->setUserName('TestUser3');
            $user3->setUserFristName('Lou');
            $user3->setUserRef('clilou6482');
            $user3->setUserPhone('123456789');
            $user3->setUserCoefficient($coeficient_base);
            $user3->setCommercialRef($comuser3);

            $manager->persist($user3);

                //adress

                $adress3 = new Adress();
                $adress3->setAdrNumber('123');
                $adress3->setAdrStreet('avenue charle');
                $adress3->setAdrZipCode('80554');
                $adress3->setAdrCity('testCity');
                $adress3->addUser($user3);
        
                $manager->persist($adress2);
            
            // Client Pro

                //1

                $prouser1 = new Users();
                $prouser1->setUserEmail('pro1@example.com');
                $prouser1->setRoles(['ROLE_USER']);
                $prouser1->setPassword($this->hasher->hashPassword($prouser1, 'admin'));
                $prouser1->setUserName('TestUser1');
                $prouser1->setUserFristName('Jim');
                $prouser1->setUserRef('projim8452');
                $prouser1->setUserPhone('123456789');
                $prouser1->setUserCoefficient($coeficient_base);
                $prouser1->setUserCompanyName('OrchestreLe1');
                $prouser1->setUserCompanySiret('84521569854758');
                $prouser1->setUserCompanyCoefficient(1.6);
                $prouser1->setCommercialRef($comuser2);

                $manager->persist($prouser1);

                    //adress

                    $adress4 = new Adress();
                    $adress4->setAdrNumber('45');
                    $adress4->setAdrStreet('rue de la guerre');
                    $adress4->setAdrZipCode('12345');
                    $adress4->setAdrCity('Cityville');
                    $adress4->setAdrAddInfo('Batiment avec la grande baie vitre');
                    $adress4->addUser($prouser1);
            
                    $manager->persist($adress4);

                //2

                $prouser2 = new Users();
                $prouser2->setUserEmail('pro2@example.com');
                $prouser2->setRoles(['ROLE_USER']);
                $prouser2->setPassword($this->hasher->hashPassword($prouser2, 'admin'));
                $prouser2->setUserName('TestUser2');
                $prouser2->setUserFristName('Katy');
                $prouser2->setUserRef('proKaty8452');
                $prouser2->setUserPhone('123456789');
                $prouser2->setUserCoefficient($coeficient_base);
                $prouser2->setUserCompanyName('InstumentNet');
                $prouser2->setUserCompanySiret('84265789525684');
                $prouser2->setUserCompanyCoefficient(1.2);
                $prouser2->setCommercialRef($comuser2);

                $manager->persist($prouser2);

                    //adress

                    $adress5 = new Adress();
                    $adress5->setAdrNumber('52');
                    $adress5->setAdrStreet('avenu de la paix');
                    $adress5->setAdrZipCode('12345');
                    $adress5->setAdrCity('Cityville');
                    $adress5->setAdrAddInfo('batiment2');
                    $adress5->addUser($prouser2);
            
                    $manager->persist($adress5);

                //3

                $prouser3 = new Users();
                $prouser3->setUserEmail('pro3@example.com');
                $prouser3->setRoles(['ROLE_USER']);
                $prouser3->setPassword($this->hasher->hashPassword($prouser3, 'admin'));
                $prouser3->setUserName('TestUser3');
                $prouser3->setUserFristName('Noe');
                $prouser3->setUserRef('pronoe8431');
                $prouser3->setUserPhone('123456789');
                $prouser3->setUserCoefficient($coeficient_base);
                $prouser3->setUserCompanyName('BuyCorde');
                $prouser3->setUserCompanySiret('85412569874525');
                $prouser3->setUserCompanyCoefficient(1.3);
                $prouser3->setCommercialRef($comuser3);

                $manager->persist($prouser3);

                    //adress

                    $adress6 = new Adress();
                    $adress6->setAdrNumber('45');
                    $adress6->setAdrStreet('rue de la guerre');
                    $adress6->setAdrZipCode('12345');
                    $adress6->setAdrCity('Cityville');
                    $adress6->addUser($prouser3);
            
                    $manager->persist($adress6);

        // Send data
        $manager->flush();
    }
}
