<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Adress;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Delivery;
use App\Entity\Orders;
use App\Entity\ProductDelivery;
use App\Entity\ProductOrders;
use App\Entity\SubCategory;
use App\Entity\Supplier;
use App\Entity\Users;
use DateInterval;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\VarDumper\VarDumper;

class JeuTest extends Fixture
{
    //Function
    private $hasher;
    //calcul prix total
    public function calprixtotal ($quantityboucle,$coeficient_base,$prixarticle,$tva ) {
        return $prixtotal = ((($prixarticle*$quantityboucle)*$coeficient_base)*$tva);
    }
            
    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }

    //gen Date
    function date_gen_ant($DateJ)   {

        $date_gen = clone $DateJ;
        $rdn = rand(1,3);

        $date_retourn = $DateJ->sub(new DateInterval("P" . $rdn . "W"));

        return $date_retourn;
    }

    function date_gen_sup($DateJ)
    {
        $date_gen = clone $DateJ;
        $rdn = rand(1,3);

        $date_retourn = $date_gen->add(new DateInterval("P" . $rdn . "W"));

        return $date_retourn;
    }

    //Data
    public function load(ObjectManager $manager): void
    {
        //Varibale :

            $coeficient_base = 1.8;
            $x = 100;
        
        //Users Commercial

            //1 possede 2 particulier

            $comuser1 = new Users();
            $comuser1->setUserEmail('commercial1@example.com');
            $comuser1->setRoles(['ROLE_COM']);
            $comuser1->setPassword($this->hasher->hashPassword($comuser1, 'admin'));
            $comuser1->setUserName('TestUser1');
            $comuser1->setUserFristName('Brian');
            $comuser1->setUserRef('combria8457');
            $comuser1->setUserPhone('123456789');
            $comuser1->setIsVerified('1');
            $comuser1->setUserCoefficient($coeficient_base);

            $manager->persist($comuser1);

            //2 posede 2 professionel

            $comuser2 = new Users();
            $comuser2->setUserEmail('comercial2@example.com');
            $comuser2->setRoles(['ROLE_COM']);
            $comuser2->setPassword($this->hasher->hashPassword($comuser2, 'admin'));
            $comuser2->setUserName('TestUser2');
            $comuser2->setUserFristName('Bastian');
            $comuser2->setUserRef('combas8452');
            $comuser2->setUserPhone('123456789');
            $comuser2->setIsVerified('1');
            $comuser2->setUserCoefficient($coeficient_base);

            $manager->persist($comuser2);

            //3 possede 1 pro 1 particulier

            $comuser3 = new Users();
            $comuser3->setUserEmail('commercial3@example.com');
            $comuser3->setRoles(['ROLE_COM']);
            $comuser3->setPassword($this->hasher->hashPassword($comuser3, 'admin'));
            $comuser3->setUserName('TestUser3');
            $comuser3->setUserFristName('Zoé');
            $comuser3->setUserRef('comzoe8452');
            $comuser3->setUserPhone('123456789');
            $comuser3->setIsVerified('1');
            $comuser3->setUserCoefficient($coeficient_base);

            $manager->persist($comuser3);

        //Users Particulier

            //1

            $user[1] = new Users();
            $user[1]->setUserEmail('particulier1@example.com');
            $user[1]->setRoles(['ROLE_USER']);
            $user[1]->setPassword($this->hasher->hashPassword($user[1], 'admin'));
            $user[1]->setUserName('TestUser1');
            $user[1]->setUserFristName('John');
            $user[1]->setUserRef('clijohn1486');
            $user[1]->setUserPhone('123456789');
            $user[1]->setUserCoefficient($coeficient_base);
            $user[1]->setIsVerified('1');
            $user[1]->setCommercialRef($comuser1);

            $manager->persist($user[1]);

                //adress

                $adress1 = new Adress();
                $adress1->setAdrNumber('123');
                $adress1->setAdrStreet('Main Street');
                $adress1->setAdrZipCode('12345');
                $adress1->setAdrCity('Cityville');
                $adress1->setAdrAddInfo('2eme etage');
                $adress1->addUser($user[1]);
        
                $manager->persist($adress1);

            //2

            $user[2] = new Users();
            $user[2]->setUserEmail('particulier2@example.com');
            $user[2]->setRoles(['ROLE_USER']);
            $user[2]->setPassword($this->hasher->hashPassword($user[2], 'admin'));
            $user[2]->setUserName('TestUser2');
            $user[2]->setUserFristName('Kim');
            $user[2]->setUserRef('clikim1524');
            $user[2]->setUserPhone('123456789');
            $user[2]->setUserCoefficient($coeficient_base);
            $user[2]->setIsVerified('1');
            $user[2]->setCommercialRef($comuser1);

            $manager->persist($user[2]);

                //adress

                $adress2 = new Adress();
                $adress2->setAdrNumber('24');
                $adress2->setAdrStreet('rue pierre');
                $adress2->setAdrZipCode('80514');
                $adress2->setAdrCity('Villetest');
                $adress2->addUser($user[2]);
        
                $manager->persist($adress2);

            //3

            $user[3] = new Users();
            $user[3]->setUserEmail('particulier3@example.com');
            $user[3]->setRoles(['ROLE_USER']);
            $user[3]->setPassword($this->hasher->hashPassword($user[3], 'admin'));
            $user[3]->setUserName('TestUser3');
            $user[3]->setUserFristName('Lou');
            $user[3]->setUserRef('clilou6482');
            $user[3]->setUserPhone('123456789');
            $user[3]->setUserCoefficient($coeficient_base);
            $user[3]->setIsVerified('1');
            $user[3]->setCommercialRef($comuser3);

            $manager->persist($user[3]);

                //adress

                $adress3 = new Adress();
                $adress3->setAdrNumber('123');
                $adress3->setAdrStreet('avenue charle');
                $adress3->setAdrZipCode('80554');
                $adress3->setAdrCity('testCity');
                $adress3->addUser($user[3]);
        
                $manager->persist($adress3);
            
            // Client Pro

                //1

                $prouser[1] = new Users();
                $prouser[1]->setUserEmail('pro1@example.com');
                $prouser[1]->setRoles(['ROLE_PRO']);
                $prouser[1]->setPassword($this->hasher->hashPassword($prouser[1], 'admin'));
                $prouser[1]->setUserName('TestUser1');
                $prouser[1]->setUserFristName('Jim');
                $prouser[1]->setUserRef('projim8452');
                $prouser[1]->setUserPhone('123456789');
                $prouser[1]->setUserCoefficient($coeficient_base);
                $prouser[1]->setUserCompanyName('OrchestreLe1');
                $prouser[1]->setUserCompanySiret('84521569854758');
                $prouser[1]->setUserCompanyCoefficient(1.6);
                $prouser[1]->setIsVerified('1');
                $prouser[1]->setCommercialRef($comuser2);

                $manager->persist($prouser[1]);

                    //adress

                    $adress4 = new Adress();
                    $adress4->setAdrNumber('45');
                    $adress4->setAdrStreet('rue de la guerre');
                    $adress4->setAdrZipCode('12345');
                    $adress4->setAdrCity('Cityville');
                    $adress4->setAdrAddInfo('Batiment avec la grande baie vitre');
                    $adress4->addUser($prouser[1]);
                    
                    $manager->persist($adress4);


                //2

                $prouser[2] = new Users();
                $prouser[2]->setUserEmail('pro2@example.com');
                $prouser[2]->setRoles(['ROLE_PRO']);
                $prouser[2]->setPassword($this->hasher->hashPassword($prouser[2], 'admin'));
                $prouser[2]->setUserName('TestUser2');
                $prouser[2]->setUserFristName('Katy');
                $prouser[2]->setUserRef('proKaty8452');
                $prouser[2]->setUserPhone('123456789');
                $prouser[2]->setUserCoefficient($coeficient_base);
                $prouser[2]->setUserCompanyName('InstumentNet');
                $prouser[2]->setUserCompanySiret('84265789525684');
                $prouser[2]->setUserCompanyCoefficient(1.2);
                $prouser[2]->setIsVerified('1');
                $prouser[2]->setCommercialRef($comuser2);

                $manager->persist($prouser[2]);

                    //adress

                    $adress5 = new Adress();
                    $adress5->setAdrNumber('52');
                    $adress5->setAdrStreet('avenu de la paix');
                    $adress5->setAdrZipCode('12345');
                    $adress5->setAdrCity('Cityville');
                    $adress5->setAdrAddInfo('batiment2');
                    $adress5->addUser($prouser[2]);
            
                    $manager->persist($adress5);

                //3

                $prouser[3] = new Users();
                $prouser[3]->setUserEmail('pro3@example.com');
                $prouser[3]->setRoles(['ROLE_PRO']);
                $prouser[3]->setPassword($this->hasher->hashPassword($prouser[3], 'admin'));
                $prouser[3]->setUserName('TestUser3');
                $prouser[3]->setUserFristName('Noe');
                $prouser[3]->setUserRef('pronoe8431');
                $prouser[3]->setUserPhone('123456789');
                $prouser[3]->setUserCoefficient($coeficient_base);
                $prouser[3]->setUserCompanyName('BuyCorde');
                $prouser[3]->setUserCompanySiret('85412569874525');
                $prouser[3]->setUserCompanyCoefficient(1.3);
                $prouser[3]->setIsVerified('1');
                $prouser[3]->setCommercialRef($comuser3);

                $manager->persist($prouser[3]);


                    //adress

                    $adress6 = new Adress();
                    $adress6->setAdrNumber('45');
                    $adress6->setAdrStreet('rue de la guerre');
                    $adress6->setAdrZipCode('12345');
                    $adress6->setAdrCity('Cityville');
                    $adress6->addUser($prouser[3]);
            
                    $manager->persist($adress6);

                    //fake client

                    for ($i = 4; $i <= 25; $i++) {

                        $user[$i] = new Users();
                        $user[$i]->setUserEmail("particulier{$i}@example.com");
                        $user[$i]->setRoles(['ROLE_USER']);
                        $user[$i]->setPassword($this->hasher->hashPassword($user[$i], 'admin'));
                        $user[$i]->setUserName("TestUser{$i}");
                        $user[$i]->setUserFristName("John{$i}");
                        $user[$i]->setUserRef("clijohn{$i}");
                        $user[$i]->setUserPhone("12345678{$i}");
                        $user[$i]->setUserCoefficient($coeficient_base);
                        $user[$i]->setIsVerified('1');
                        $user[$i]->setCommercialRef($comuser1);
                    
                        $manager->persist($user[$i]);
                        var_dump("creation user particulier " . $i );
                        // Création de l'adresse pour cet utilisateur
                        $address[$i] = new Adress();
                        $address[$i]->setAdrNumber("55");
                        $address[$i]->setAdrStreet('Main Street');
                        $address[$i]->setAdrZipCode("$i.2345");
                        $address[$i]->setAdrCity('Cityville');
                        $address[$i]->setAdrAddInfo("$i eme etage");
                        $address[$i]->addUser($user[$i]);
                    
                        $manager->persist($address[$i]);
                    }
                    
                    // Création de 15 utilisateurs professionnels
                    for ($i = 4; $i <= 25; $i++) {

                        $prouser[$i] = new Users();
                        $prouser[$i]->setUserEmail("pro{$i}@example.com");
                        $prouser[$i]->setRoles(['ROLE_PRO']);
                        $prouser[$i]->setPassword($this->hasher->hashPassword($prouser[$i], 'admin'));
                        $prouser[$i]->setUserName("TestProUser{$i}");
                        $prouser[$i]->setUserFristName("ProFirstName{$i}");
                        $prouser[$i]->setUserRef("pro{$i}");
                        $prouser[$i]->setUserPhone('123456789');
                        $prouser[$i]->setUserCoefficient($coeficient_base);
                        $prouser[$i]->setUserCompanyName("Company{$i}");
                        $prouser[$i]->setUserCompanySiret(mt_rand(10000000000000, 99999999999999));
                        $prouser[$i]->setUserCompanyCoefficient(mt_rand(110, 150) / 100);
                        $prouser[$i]->setIsVerified('1');
                        $prouser[$i]->setCommercialRef($comuser3);
                        
                        $manager->persist($prouser[$i]);
                        var_dump('creation user pro' . $i);

                        $proaddress[$i] = new Adress();
                        $proaddress[$i]->setAdrNumber("50");
                        $proaddress[$i]->setAdrStreet('Main Street');
                        $proaddress[$i]->setAdrZipCode("12345");
                        $proaddress[$i]->setAdrCity('Cityville');
                        $proaddress[$i]->setAdrAddInfo("$i eme floor");
                        $proaddress[$i]->addUser($prouser[$i]);
                    
                        $manager->persist($proaddress[$i]);
                    }
            
                    //Supplier

                        //1 

                        $supplier1 = new Supplier();
                        $supplier1->setSupName('Supplier 1');
                        $supplier1->setSupRef('SUP001');
                        $supplier1->setSupType(1);
                        $supplier1->setSupPhone('123456789');
                        $supplier1->setSupMail('supplier1@example.com');
                        $supplier1->setSupAddress('123 Main Street');
                        $supplier1->setSupCodePostal(12345);
                        $supplier1->setSupNumberAddress('A1');
                        $supplier1->setSupVille('City1');

                        $manager->persist($supplier1);

                        //2

                        $supplier2 = new Supplier();
                        $supplier2->setSupName('Supplier 2');
                        $supplier2->setSupRef('SUP002');
                        $supplier2->setSupType(1);
                        $supplier2->setSupPhone('123456789');
                        $supplier2->setSupMail('supplier2@example.com');
                        $supplier2->setSupAddress('123 Main Street');
                        $supplier2->setSupCodePostal(12345);
                        $supplier2->setSupNumberAddress('A1');
                        $supplier2->setSupVille('City1');

                        $manager->persist($supplier2);

                        //3

                        $supplier3 = new Supplier();
                        $supplier3->setSupName('Supplier 3');
                        $supplier3->setSupRef('SUP003');
                        $supplier3->setSupType(1);
                        $supplier3->setSupPhone('123456789');
                        $supplier3->setSupMail('supplier3@example.com');
                        $supplier3->setSupAddress('123 Main Street');
                        $supplier3->setSupCodePostal(12345);
                        $supplier3->setSupNumberAddress('A1');
                        $supplier3->setSupVille('City1');

                        $manager->persist($supplier3);

            //Produit Categorie SousCategorie

                //1
                
                $category1 = new Category();
                $category1->setCatName('Clavier | Piano');
                $category1->setCatPictureName('clavier.jpg');
        
                $manager->persist($category1);

                    //Sous Category

                        //1

                        $subcategory1 = new SubCategory();
                        $subcategory1->setSubName('Piano numérique');
                        $subcategory1->setSubPictureName('pianonumerique.jpg');
                        $subcategory1->setCategorys($category1);
                
                        $manager->persist($subcategory1);

                            //Produit 1 

                            $product1 = new Product();
                            $product1->setProName('Hemingway DP-701 MKII BP');
                            $product1->setProDesc('88 touches lestées, Mécanique à marteaux, Ecran LCD avec rétro-éclairage bleu, 32 sons + voix GM, Réverbération, Chorus, 16 morceaux de démonstration, Polyphonie 64 voix, Métronome, Fonction Transpose, Fonction Split, Fonction Layer, 3 pédales, Couvre clavier rétractable, Enregistreur interne: 3 pistes, 90.000 notes, Enregistreur USB MIDI, Mode Duet, 2 sorties casque, Sorties ligne L/R, Entrée ligne, Sortie MIDI, USB to Host (Windows 8 ou plus récent, Mac OSX 10.8 ou plus récent), USB to Device, Bluetooth, Système de haut-parleurs: 2 x 20 Watt + 2 x 5 Watt, Bloc d\'limentation incl., Dimensions (L x P x H): 1400 x 490 x 860 mm, Poids: 54 kg, Design: Noir poli');
                            $product1->setProPictureName('Hemingway_DP-701_MKII BP.jpg');
                            $product1->setProPriceHT('639');
                            $product1->setProActive(1);
                            $product1->setProRef('pianum001');
                            $product1->setSubcategory($subcategory1);
                            $product1->setSuppliers($supplier1);

                            $manager->persist($product1);

                            //Produit 2 

                            $product2 = new Product();
                            $product2->setProName('Roland GO:PIANO');
                            $product2->setProDesc('88 touches lestées,Mécanique à marteaux,Ecran LCD avec rétro-éclairage bleu,32 sons + voix GM,Réverbération,Chorus,Polyphonie 64 voix,Métronome,Fonction Transpose,Fonction Split,Fonction Layer,3 pédales,Couvre clavier rétractable,Enregistreur interne: 3 pistes, 90.000 notes,Enregistreur USB MIDI,Mode Duet,2 sorties casque,Sorties ligne L/R,Entrée ligne,Sortie MIDI,USB to Host (Windows 8 ou plus récent, Mac OSX 10.8 ou plus récent),USB to Device,Bluetooth,Système de haut-parleurs: 2 x 20 Watt + 2 x 5 Watt,Bloc d\'alimentation incl,Dimensions (L x P x H): 1400 x 490 x 860 mm,Poids: 54 kg,Design: Noir poli,');
                            $product2->setProPictureName('Roland_GO:PIANO.jpg');
                            $product2->setProPriceHT('259');
                            $product2->setProActive(1);
                            $product2->setProRef('pianum002');
                            $product2->setSubcategory($subcategory1);
                            $product2->setSuppliers($supplier1);

                            $manager->persist($product2);

                            //Produit 3

                            $product3 = new Product();
                            $product3->setProName('Yamaha YDP-145 WH Arius');
                            $product3->setProDesc('88 touches, Mécanique à marteaux (GHS), 10 sons (y compris le son haut de gamme du piano à queue Yamaha CFX), Polyphonie 192 voix, Effets: 4 types de réverbération, optimisation stéréophonique, contrôle acoustique intelligent, Enregistrement MIDI (2 pistes), Fonctions: Dual, mode Duo, métronome, transposition (-6 / +6), accordage (414,8 - 466,8 kHz), 3 pédales: Sustain (demi-pédale), Sostenuto, Soft, USB to Host, 2 sorties casque sur Jack stéréo 6,3 mm, Système de haut-parleurs: 2 x 8 Watt, Dimensions (L x P x H): 1357 x 422 x 815 mm (hauteur avec pupitre: 969 mm, Poids: 38 kg, Couleur: Blanc, Bloc d\'limentation (PA-150) et partition "50 Classical Music Masterpieces" incl.');
                            $product3->setProPictureName('Yamaha_YDP-145_WH_Arius.jpg');
                            $product3->setProPriceHT('898');
                            $product3->setProActive(1);
                            $product3->setProRef('pianum003');
                            $product3->setSubcategory($subcategory1);
                            $product3->setSuppliers($supplier2);

                            $manager->persist($product3);

                        //2

                        $subcategory2 = new SubCategory();
                        $subcategory2->setSubName('Clavier Arrangeurs');
                        $subcategory2->setSubPictureName('arrangeur.jpg');
                        $subcategory2->setCategorys($category1);
                
                        $manager->persist($subcategory2);

                            //produit 1

                            $product4 = new Product();
                            $product4->setProName('Yamaha PSS-A50');
                            $product4->setProDesc('37 touches miniatures sensibles à la vélocité, Polyphonie 32 voix, 42 sons (instruments), 138 types d\'rpèges, Enregistreur de phrases, Effet de mouvement, Connexion USB-MIDI (configuration pour home recording DAW), Fonctionne avec 4 piles AA ou port USB (bloc d\'limentation');
                            $product4->setProPictureName('Yamaha_PSS-A50.jpg');
                            $product4->setProPriceHT('85');
                            $product4->setProActive(1);
                            $product4->setProRef('claaran001');
                            $product4->setSubcategory($subcategory2);
                            $product4->setSuppliers($supplier2);

                            $manager->persist($product4);

                            //produit 2

                            $product5 = new Product();
                            $product5->setProName('Yamaha PSR-SX900');
                            $product5->setProDesc('61 touches sensibles à la vélocité, Nouveau clavier FSB, 1337 sons + 56 kits de batterie/SFX + 480 voix XG, 525 styles, Polyphonie 128 voix, Parties du clavier jusqu\'à Right Part3, Boutons, joystick et contrôleur Live assignables, Fonctions Chord Looper, Vocal Harmony et Synth Vocoder, Style d\'extension audio, Son compatible XG/GM/GM2/GS, Styles DJ, Fonction Arpeggio, 1 GB de mémoire d\'extension interne, Ecran tactile, Multi pads Audio Link, Enregistreur/lecteur audio WAV et MP3, Changement de hauteur (Pitch Shift), Looper d\'accords, Bluetooth audio, Sortie casque, Entrée Mic/Guitar, MIDI In/Out, USB to Host, USB to Device (2x), Entrée Aux, Sorties Main (L/L+R, R), Sortie Sub (1,2 (L/L+R, R), Connexion pour pédale de sustain, Système de haut-parleurs: 2 x 20 Watt (graves) + 2 x 15 Watt (médiums/aigus), Dimensions: 1017 x 431 x 139 mm, Poids: 11,5 kg, Bloc d\'limentation PA-300C, pupitre et manuel d\'utilisation incl., Adaptateur d\'ffichage adapté optionnel non-fourni (N° d\'rticle 431245), Housse de protection adaptée optionnelle non-fournie (N° d\'rticle 497394)');
                            $product5->setProPictureName('Yamaha_PSR-SX900.jpg');
                            $product5->setProPriceHT('1979');
                            $product5->setProActive(1);
                            $product5->setProRef('claaran002');
                            $product5->setSubcategory($subcategory2);
                            $product5->setSuppliers($supplier2);

                            $manager->persist($product5);

                            //produit 3

                            $product6 = new Product();
                            $product6->setProName('Startone MK-300');
                            $product6->setProDesc('Idéal pour débuter dans le monde du clavier arrangeur grâce à ses nombreuses fonctions, 61 touches sensibles à la vélocité, Polyphonie 64 voix, 390 sons, 100 styles, 110 chansons, 8 chansons de démonstration, Mode Dual : 2 sons simultanément, Avec effet sustain, Lower : affectation des touches pour la main gauche, Métronome, Splittage du clavier, Pitch Bend, Enregistrement et lecture, Système de haut-parleurs : 2x 10 Watt, Transposeur, Pupitre amovible, Possibilité de fonctionnement avec 6 piles AA (optionnelles non fournies), Dimensions (L x P x H) : 955 x 360 x 145 mm, Poids: 4,5 kg, Bloc d\'limentation incl., Pédale de sustain adaptée 320312 optionnelle non fournie, Housse de protection adaptée 486652 ou 493056 optionnelle non fournie');
                            $product6->setProPictureName('Startone_MK-300.jpg');
                            $product6->setProPriceHT('135');
                            $product6->setProActive(1);
                            $product6->setProRef('claaran003');
                            $product6->setSubcategory($subcategory2);
                            $product6->setSuppliers($supplier1);

                            $manager->persist($product6);

                        //3

                        $subcategory3 = new SubCategory();
                        $subcategory3->setSubName('Piano a queu');
                        $subcategory3->setSubPictureName('queu.jpg');
                        $subcategory3->setCategorys($category1);
                
                        $manager->persist($subcategory3);

                            // 1
                            $product7 = new Product();
                            $product7->setProName('Yamaha GB1 K Black Polished');
                            $product7->setProDesc('88 touches, 3 pédales (pédale centrale pour maintien de la tonalité), Longueur: 151 cm, Largeur: 146 cm, Hauteur: 99 cm, Poids: 261 kg, Finition: Noir brillant, Livré avec un banc');
                            $product7->setProPictureName('Yamaha_GB1_K_Black_Polished.jpg');
                            $product7->setProPriceHT('9999.99');
                            $product7->setProActive(1);
                            $product7->setProRef('YGP001');
                            $product7->setSubcategory($subcategory3);
                            $product7->setSuppliers($supplier2);
                            $manager->persist($product7);

                            // 2
                            $product8 = new Product();
                            $product8->setProName('Kawai GL 50 EP Grand Piano');
                            $product8->setProDesc('Duplex scale: double diapason, Mécaniques ultra-réactives, Marteaux feutrés, Capot à fermeture sans bruit, Longueur: 186 cm, Finition: noir, Poids: 352 kg');
                            $product8->setProPictureName('Kawai_GL_50_EP_Grand_Piano.jpg');
                            $product8->setProPriceHT('14999.99');
                            $product8->setProActive(1);
                            $product8->setProRef('SSGP002');
                            $product8->setSubcategory($subcategory3);
                            $product8->setSuppliers($supplier3);
                            $manager->persist($product8);

                            // 3
                            $product9 = new Product();
                            $product9->setProName('Kawai GL 30 EP Grand Piano');
                            $product9->setProDesc('Duplex scale: double diapason, Mécaniques ultra-réactives, Marteaux feutrés, Capot à fermeture sans bruit, Longueur: 166 cm, Finition: noir brillant, Poids: 312 kg');
                            $product9->setProPictureName('Kawai_GL_30_EP_Grand_Piano.jpg');
                            $product9->setProPriceHT('18999.99');
                            $product9->setProActive(1);
                            $product9->setProRef('BGP003');
                            $product9->setSubcategory($subcategory3);
                            $product9->setSuppliers($supplier3);
                            $manager->persist($product9);

             //2
                
             $category2 = new Category();
             $category2->setCatName('Batteries');
             $category2->setCatPictureName('batteries.jpg');
     
             $manager->persist($category2);

                 //Sous Category

                     //1

                     $subcategory4 = new SubCategory();
                     $subcategory4->setSubName('Batteries Electroniques');
                     $subcategory4->setSubPictureName('batterieselectroniques.jpg');
                     $subcategory4->setCategorys($category2);
             
                     $manager->persist($subcategory4);

                        // 1
                        $product10 = new Product();
                        $product10->setProName('Millenium MX420 Studio Set RL');
                        $product10->setProDesc('Version Studio, Grosse caisse 20"x16" (avec attache pour supports de toms), Tom 10"x08", Tom 12"x09", Stand tom 14"x14", Caisse claire 14"x5,5", Fûts 9 plis en peuplier/bouleau, Cercles caisse claire/toms en métal 1,5 mm, Cercles de la grosse caisse en bois de couleur identique aux fûts, Finition: Rhodoïd, Couleur: Red Lining');
                        $product10->setProPictureName('Millenium_MX420_Studio_Set_RL.jpg');
                        $product10->setProPriceHT('428.99');
                        $product10->setProActive(1);
                        $product10->setProRef('MLSSR001');
                        $product10->setSubcategory($subcategory4);
                        $product10->setSuppliers($supplier3);
                        $manager->persist($product10);

                        // 2
                        $product11 = new Product();
                        $product11->setProName('Millenium Focus Junior Drum Set Black');
                        $product11->setProDesc('Série Focus, Convient aux enfants de 4 à 7 ans, Grosse caisse 16"x10", Tom 08"x05", Tom 10"x06", Stand tom 13"x11", Caisse claire en bois 12"x05", Finition: Rhodoïd, Couleur: Noir, Paire de baguettes incl., Coussin atténuateur d\'harmoniques pour grosse caisse incl.');
                        $product11->setProPictureName('Focus_Junior_Drum_Set_Black.jpg');
                        $product11->setProPriceHT('179.99');
                        $product11->setProActive(1);
                        $product11->setProRef('MLSSR002');
                        $product11->setSubcategory($subcategory4);
                        $product11->setSuppliers($supplier3);
                        $manager->persist($product11);

                        // 3
                        $product12 = new Product();
                        $product12->setProName('Mapex Tornado Stand. Zildjian Set DR');
                        $product12->setProDesc('Caisse 16"x10", Tom 08"x05", Tom 10"x06", Stand tom 13"x11", Caisse claire en bois 12"x05", Finition: Rhodoïd, Couleur: Noir');
                        $product12->setProPictureName('Mapex_Tornado_Stand_Zildjian_Set_DR.jpg');
                        $product12->setProPriceHT('598.99');
                        $product12->setProActive(1);
                        $product12->setProRef('MTSZ001');
                        $product12->setSubcategory($subcategory4);
                        $product12->setSuppliers($supplier1);
                        $manager->persist($product12);

                     //2

                     $subcategory5 = new SubCategory();
                     $subcategory5->setSubName('Batteries Acoustiques');
                     $subcategory5->setSubPictureName('batteriesacoustiques.jpg');
                     $subcategory5->setCategorys($category2);
             
                     $manager->persist($subcategory5);

                        // 1
                        $product13 = new Product();
                        $product13->setProName('Alesis Nitro Max Kit');
                        $product13->setProDesc('La nouvelle batterie ALESIS NITRO MAX est maintenant disponible en avant-première ! Elle propose désormais la fonctionnalité Bluetooth et une entrée auxiliaire pour jouer avec vos morceaux en accompagnement avec votre téléphone, avec son support intégré sur le module. Vous retrouverez plus de 440 sons, 48 kits dont 32 prédéfinis et 16 kits utilisateurs. Nouvelle caisse claire avec rhodoïd rouge strata très élégante + peaux maillées blanches nouvelle génération. La caisse claire est de 10 pouces au lieu de 8 pouces comme la précédente.');
                        $product13->setProPictureName('Alesis_Nitro_Max_Kit.jpg');
                        $product13->setProPriceHT('399');
                        $product13->setProActive(1);
                        $product13->setProRef('ANMK001');
                        $product13->setSubcategory($subcategory5);
                        $product13->setSuppliers($supplier1);
                        $manager->persist($product13);

                        // 2
                        $product14 = new Product();
                        $product14->setProName('Roland TD-27KV2 E-Drum Set');
                        $product14->setProDesc('Avec 32 kits de batterie classiques et modernes de BFD + 16 kits utilisateur, 440 sons de batterie, cymbales et percussions, Réverbération, EQ 3 bandes, 60 pistes d\'ccompagnement, Séquenceur, métronome et enregistreur de performance, 1 pad de caisse claire 10" deux zones de jeu avec peau maillée, 3 pads de tom 8" une zone de jeu avec peaux maillées, Pad de Crash 10" avec fonction d\'étouffement, Pad de Ride 10", Pad de charleston 10" avec contrôleur au pied, Rack 4 colonnes en aluminium, Module de batterie avec des sons enregistrés de manière professionnelle à partir de la bibliothèque de batterie BFD, Streaming audio Bluetooth pour la lecture de musique sans fil, Support d\'ppareil intégré, Port USB/MIDI, Entrée Aux stéréo sur mini Jack 3,5 mm, Sortie ligne stéréo sur Jack 6,3 mm, Sortie casque stéréo sur mini Jack 3,5 mm, Comprend un abonnement gratuit de 90 jours à Drumeo et un abonnement gratuit de 30 jours à Melodics Premium ainsi que 60 leçons exclusives');
                        $product14->setProPictureName('Roland_TD-27KV2_E-Drum_Set.jpg');
                        $product14->setProPriceHT('3299');
                        $product14->setProActive(1);
                        $product14->setProRef('RTEDS202');
                        $product14->setSubcategory($subcategory5);
                        $product14->setSuppliers($supplier3);
                        $manager->persist($product14);

                        // 3
                        $product15 = new Product();
                        $product15->setProName('Millenium MPS-850 E-Drum Set Bundle');
                        $product15->setProDesc('550 sons, 30 kits prédéfinis, 20 kits utilisateur, 100 morceaux, 2 morceaux utilisateur, Enregistrement rapide, Métronome, EQ par kit, Pitch, Réverbération, Compresseur, 6 faders pour ajuster le volume individuel des pads, du métronome et des chansons, 2 sorties Main sur Jack 6,3 mm, Sortie casque sur Jack stéréo 6,3 mm, Entrée ligne sur mini Jack stéréo 3,5 mm, 2 entrées Trigger sur Jack stéréo 6,3 mm (déjà occupées par le deuxième pad Crash et le quatrième pad de tom), USB MIDI, Mémoire USB, MIDI In & Out, Import de sample WAV');
                        $product15->setProPictureName('Millenium_MPS-850_E-Drum_Set_Bundle.jpg');
                        $product15->setProPriceHT('666');
                        $product15->setProActive(1);
                        $product15->setProRef('MMPSEDSB045');
                        $product15->setSubcategory($subcategory5);
                        $product15->setSuppliers($supplier3);
                        $manager->persist($product15);

                     //3

                     $subcategory6 = new SubCategory();
                     $subcategory6->setSubName('Baguettes & Maillets');
                     $subcategory6->setSubPictureName('Baguettes.jpg');
                     $subcategory6->setCategorys($category2);
             
                     $manager->persist($subcategory6);

                        // 1
                        $product16 = new Product();
                        $product16->setProName('Thomann GTH70 Bass Drum Mallet 70mm');
                        $product16->setProDesc('Tête en feutre, Mailloche dure, Couleur: Gris, 70 x 50 mm, Manche en bois, Longueur totale: env. 34 cm, Longueur du manche: env. 28,5 cm, Fabriquée en Allemagne, Quantité livrée: 1 pièce');
                        $product16->setProPictureName('Thomann_GTH70_Bass_Drum_Mallet_70mm.jpg');
                        $product16->setProPriceHT('16.90');
                        $product16->setProActive(1);
                        $product16->setProRef('TGBDM828');
                        $product16->setSubcategory($subcategory6);
                        $product16->setSuppliers($supplier2);
                        $manager->persist($product16);

                        // 2
                        $product17 = new Product();
                        $product17->setProName('Vater 7A Manhattan Pack');
                        $product17->setProDesc('Modèle 7A, En hickory américain, Longueur: 406,4 mm, Diamètre: 13,7 mm, Olives en boi');
                        $product17->setProPictureName('Vater_7A_Manhattan_Pack.jpg');
                        $product17->setProPriceHT('48');
                        $product17->setProActive(1);
                        $product17->setProRef('V7MP002');
                        $product17->setSubcategory($subcategory6);
                        $product17->setSuppliers($supplier1);
                        $manager->persist($product17);

                        // 3
                        $product18 = new Product();
                        $product18->setProName('Vic Firth 5B American Classic Hickory');
                        $product18->setProDesc('En hickory américain, Longueur: 406 mm, Diamètre: 15,1 mm, Olives en bois');
                        $product18->setProPictureName('Vic_Firth_5B_American_Classic_Hickory.jpg');
                        $product18->setProPriceHT('14.90');
                        $product18->setProActive(1);
                        $product18->setProRef('VF5ACH006');
                        $product18->setSubcategory($subcategory6);
                        $product18->setSuppliers($supplier2);
                        $manager->persist($product18);

            //3
                
            $category3 = new Category();
            $category3->setCatName('Guitares');
            $category3->setCatPictureName('guitare.jpg');
    
            $manager->persist($category3);

                //Sous Category

                    //1

                    $subcategory7 = new SubCategory();
                    $subcategory7->setSubName('Guitares classique');
                    $subcategory7->setSubPictureName('guitareclassique.jpg');
                    $subcategory7->setCategorys($category3);
            
                    $manager->persist($subcategory7);

                        //1
                        $product19 = new Product();
                        $product19->setProName('La Mancha CM/53 Rubinito');
                        $product19->setProDesc('Taille: 1/2, Modèle 2019 / 2020 recommandé par l\'EGTA (European Guitar Teachers Association), Table en cèdre canadien massif, Fond et éclisses en acajou, Manche en nato, Touche en ovangkol, Filets en ABS noir, Diapason: 530 mm, Chevalet en ovangkol avec double passage des cordes, Sillets de tête et de chevalet NuBone, Largeur au sillet: 48 mm, Mécaniques nickelées avec boutons noirs, Cordes Savarez Cantiga High Tension 510AJ (249237), Finition: Vernis mat à pores ouverts, Couleur: Naturel');
                        $product19->setProPictureName('La_Mancha_CM53_Rubinito.jpg');
                        $product19->setProPriceHT('169');
                        $product19->setProActive(1);
                        $product19->setProRef('LMCM853');
                        $product19->setSubcategory($subcategory7);
                        $product19->setSuppliers($supplier1);
                        $manager->persist($product19);

                        // 2
                        $product20 = new Product();
                        $product20->setProName('Startone CG-851 1/2 Red');
                        $product20->setProDesc('Taille: 1/2, Corps en tilleul, Manche en nato, Touche en érable, Diapason: 550 mm, Largeur au sillet: 45 mm, Filet de corps noir, Longueur totale: 864 mm, Cordes en nylon, Couleur: Rouge satiné, Housse adaptée optionnelle non-fournie (N° d\'rticle 198578)');
                        $product20->setProPictureName('Startone_CG-851_12_Red.jpg');
                        $product20->setProPriceHT('40');
                        $product20->setProActive(1);
                        $product20->setProRef('SSC851R');
                        $product20->setSubcategory($subcategory7);
                        $product20->setSuppliers($supplier3);
                        $manager->persist($product20);

                        // 3
                        $product21 = new Product();
                        $product21->setProName('Yamaha CGS102A');
                        $product21->setProDesc('Taille: 1/2, Table en épicéa, Fond et éclisses en méranti, Touche et chevalet en palissandre, Profondeur du corps: 80 - 85 mm, Diapason: 535 mm (21,06"), Largeur au sillet: 48 mm, Mécaniques chromées, Dimensions: 870 x 310 x 85 mm, Couleur: Naturel');
                        $product21->setProPictureName('Yamaha_CGS102A.jpg');
                        $product21->setProPriceHT('139');
                        $product21->setProActive(1);
                        $product21->setProRef('CGS102A');
                        $product21->setSubcategory($subcategory7);
                        $product21->setSuppliers($supplier2);
                        $manager->persist($product21);



                    //2

                    $subcategory8 = new SubCategory();
                    $subcategory8->setSubName('Guitares Electriques');
                    $subcategory8->setSubPictureName('guitarelectrique.jpg');
                    $subcategory8->setCategorys($category3);
            
                    $manager->persist($subcategory8);

                        // 1
                        $product22 = new Product();
                        $product22->setProName('Squier Affinity Strat Laurel SG');
                        $product22->setProDesc('Corps en peuplier, Manche en érable, Profil du manche en C, Touche en laurier, Repères "points" imitation nacre, Rayon de la touche: 241 mm (9,5"), Diapason: 648 mm (25,5"), Largeur au sillet: 42 mm (1,65"), Sillet en os synthétique, 21 frettes Medium Jumbo, 3 micros simple bobinage avec aimants en céramique, Contrôles: Master Volume, Tone 1, Tone 2, Sélecteur 5 positions, Pickguard 3 plis blanc, Vibrato synchronisé 2 points avec pontets style blocs, Mécaniques fermées moulées sous pression avec axes splittés, Accastillage chromé, Couleur: Surf Green');
                        $product22->setProPictureName('Squier_Affinity_Strat_Laurel_SG.jpg');
                        $product22->setProPriceHT('195');
                        $product22->setProActive(1);
                        $product22->setProRef('sasl5g005');
                        $product22->setSubcategory($subcategory8);
                        $product22->setSuppliers($supplier1);
                        $manager->persist($product22);

                        // 2
                        $product23 = new Product();
                        $product23->setProName('Harley Benton CST-24T Amber Stripes');
                        $product23->setProDesc('Série Deluxe, Corps en méranti, Table en érable flammé, Manche collé en méranti, Touche en jatoba torréfié, Repères "points" imitation nacre, Profil du manche en C, Rayon de la touche: 350 mm, 24 frettes BlackSmith en acier inoxydable, Filets de manche et de corps, Diapason: 635 mm, Largeur au sillet: 42 mm, Sillet en graphite, 2 micros double bobinage Roswell HAF Alnico-5, 1 réglage de volume, 1 réglage de tonalité Push/Pull pour Coil Split, Sélecteur 3 positions, Vibrato Wilkinson WVPC, Accastillage DLX chromé, Mécaniques DLX, Couleur: Amber Stripes');
                        $product23->setProPictureName('Harley_Benton_CST_24T_Amber_Stripes.jpg');
                        $product23->setProPriceHT('277');
                        $product23->setProActive(1);
                        $product23->setProRef('SCGr005');
                        $product23->setSubcategory($subcategory8);
                        $product23->setSuppliers($supplier3);
                        $manager->persist($product23);

                        // 3
                        $product24 = new Product();
                        $product24->setProName('Harley Benton ST-20HH Active SBK');
                        $product24->setProDesc('Corps en peuplier, Manche vissé en érable, Touche en Roseacer, Repères "points", Profil du manche: Modern C, Diapason: 648 mm, Rayon de la touche: 305 mm, Largeur au sillet: 42 mm, 22 frettes, 2 micros double bobinage actifs HBZ à gain élevé, 1 réglage de volume, Sélecteur 3 positions, Chevalet Hardtail, Barre de réglage (Truss Rod) double action, Mécaniques moulées sous pression, Accastillage noir, Cordes .010-.046, Couleur: Noir mat');
                        $product24->setProPictureName('Harley_Benton_ST-20HH_Active_SBK.jpg');
                        $product24->setProPriceHT('148');
                        $product24->setProActive(1);
                        $product24->setProRef('HBSAS105');
                        $product24->setSubcategory($subcategory8);
                        $product24->setSuppliers($supplier2);
                        $manager->persist($product24);

                    //3

                    $subcategory9 = new SubCategory();
                    $subcategory9->setSubName('Guitares Acoustiques');
                    $subcategory9->setSubPictureName('GuitaresAcoustiques.jpg');
                    $subcategory9->setCategorys($category3);
                    $manager->persist($subcategory9);

                        // 1
                        $product25 = new Product();
                        $product25->setProName('Harley Benton Custom Line King-CE NT');
                        $product25->setProDesc('Forme Jumbo, Pan coupé, Table en épicéa massif sélectionné, Fond et éclisses en érable, Manche en érable, Touche en ovangkol, Diapason: 648 mm, Largeur au sillet: 43 mm, 20 frettes, Repères blocs imitation nacre, Chevalet en ovangkol, Sillet de chevalet en os, Filets multiplis, Barre de réglage (Truss Rod) double action, Mécaniques Grover dorées moulées sous pression, Système de micro Fishman Presys II avec accordeur intégré, Finition: Haute brillance, Couleur: Naturel');
                        $product25->setProPictureName('Harley_Benton_Custom_Line_King-CE_NT');
                        $product25->setProPriceHT('295');
                        $product25->setProActive(1);
                        $product25->setProRef('HBCLKCN0125');
                        $product25->setSubcategory($subcategory9);
                        $product25->setSuppliers($supplier2);
                        $manager->persist($product25);

                        // 2
                        $product26 = new Product();
                        $product26->setProName('Harley Benton CLD-15MCE SolidWood');
                        $product26->setProDesc('Série Custom Line Solid Wood, Forme Dreadnought avec pan coupé, Table en okoumé massif, Fond et éclisses en okoumé massif, Barrage en X sculpté (scallopé), Manche en okoumé, Touche en pau ferro, Repères "flocons de neige", Profil du manche: C ovale, Diapason: 643 mm (25,3"), Largeur au sillet: 43 mm (1,69"), Sillet de tête en os, 20 frettes, Système de micro Fishman Presys II, Chevalet en pau ferro avec sillet en os, Mécaniques ouvertes Deluxe Antique Copper, Cordes d\'ddario XTAPB1253 .012-.053 (471307), Couleur: Naturel satiné');
                        $product26->setProPictureName('Harley_Benton_CLD-15MCE_SolidWood.jpg');
                        $product26->setProPriceHT('298');
                        $product26->setProActive(1);
                        $product26->setProRef('HBCMCS219');
                        $product26->setSubcategory($subcategory9);
                        $product26->setSuppliers($supplier3);
                        $manager->persist($product26);

                        // 3
                        $product27 = new Product();
                        $product27->setProName('Harley Benton HBO-850 Blue');
                        $product27->setProDesc('Pan coupé, Table en épicéa, Corps Super Shallow Bowl en ABS, Manche en acajou, Touche en Roseacer, Repères "flocons de neige", 24 frettes, Filet de corps couleur crème, Diapason: 650 mm, Largeur au sillet: 43 mm, Chevalet en Roseacer, Système de micro avec EQ 3 bandes, Mécaniques moulées sous pression, Tirant des cordes: 011 - 052, Finition: Haute brillance, Couleur: Bleu');
                        $product27->setProPictureName('Harley_Benton_HBO-850_Blue.jpg');
                        $product27->setProPriceHT('129');
                        $product27->setProActive(1);
                        $product27->setProRef('HBHB120');
                        $product27->setSubcategory($subcategory9);
                        $product27->setSuppliers($supplier2);
                        $manager->persist($product27);

        // Ajout categorie

        $categoryVents = new Category();
        $categoryVents->setCatName('Vents');
        $categoryVents->setCatPictureName('vents.jpg');

        $manager->persist($categoryVents);

                //Sous categorie

                $subcategorySaxophones = new SubCategory();
                $subcategorySaxophones->setSubName('Saxophones');
                $subcategorySaxophones->setSubPictureName('saxophones.jpg');
                $subcategorySaxophones->setCategorys($categoryVents);
                $manager->persist($subcategorySaxophones);

                                //

                                $product28 = new Product();

                                $product28->setProName('Yamaha YAS-280 Alto Sax');
                                $product28->setProDesc('Corps et mécanique en laiton. Admission du bocal améliorée, bascule Si-Do# grave améliorée. Clé de Fa# aigu, clé de Fa avant, repose-pouce réglable. Protection des clés continue. Poids : 2,4 kg. Finition : Vernis doré. Étui souple avec sangles sac à dos, bec Yamaha 4C, sangle et graisse pour liège incl.');
                                $product28->setProPriceHT(998);
                                $product28->setProActive(true); 
                                $product28->setProRef('yyas548'); 
                                $product28->setProPictureName('Yamaha_280_Alto_Sax.jpg');
                                $product28->setSubcategory($subcategorySaxophones);
                                $product28->setSuppliers($supplier2);
                                $manager->persist($product28);

                                $product29 = new Product();

                                $product29->setProName('Startone SAS-75 Alto Sax');
                                $product29->setProDesc('Admission du bocal améliorée, bascule Si-Do# grave améliorée. Clé de Fa# aigu, clé de Fa avant, repose-pouce réglable. Protection des clés continue. Poids : 2,4 kg. Finition : Vernis doré. Étui souple avec sangles sac à dos, bec Yamaha 4C, sangle et graisse pour liège incl.');
                                $product29->setProPriceHT(289);
                                $product29->setProActive(true); 
                                $product29->setProRef('ssadt51200'); 
                                $product29->setProPictureName('Startone_SAS_75_Alto_Sax.jpg');
                                $product29->setSubcategory($subcategorySaxophones);
                                $product29->setSuppliers($supplier1);
                                $manager->persist($product29);

                                $product30 = new Product();

                                $product30->setProName('Selmer SE-A2L Goldlac SA80 II AltoSax');
                                $product30->setProDesc('Jubilée Design. Corps gravé. Clé de Fa# aigu. Résonateurs en métal. Finition : Vernis doré. Bec S80 C* et étui souple inclus.');
                                $product30->setProPriceHT(5298);
                                $product30->setProActive(true); 
                                $product30->setProRef('segsa5412'); 
                                $product30->setProPictureName('Selmer_Goldlac_SA80_II_AltoSax.jpg');
                                $product30->setSubcategory($subcategorySaxophones);
                                $product30->setSuppliers($supplier1);
                                $manager->persist($product30);

                $subcategoryClarinettes = new SubCategory();
                $subcategoryClarinettes->setSubName('Clarinettes');
                $subcategoryClarinettes->setSubPictureName('clarinettes.jpg');
                $subcategoryClarinettes->setCategorys($categoryVents);
                $manager->persist($subcategoryClarinettes);

                                //


                        $product31 = new product();
                        $product31->setProName('Buffet Crampon R13 Clarinet');
                        $product31->setProDesc('Corps en grenadille sélectionnée. Clé de Mi grave. Finition : Argenté. Bec Vandoren B45 et étui rigide inclus.');
                        $product31->setProPriceHT(2345);
                        $product31->setProActive(true);
                        $product31->setProRef('bcra6890');
                        $product31->setProPictureName('Buffet_Crampon_R13_Clarinet.jpg');
                        $product31->setSubcategory($subcategoryClarinettes);
                        $product31->setSuppliers($supplier3);
                        $manager->persist($product31);

                        $product32 = new product();
                        $product32->setProName('Yamaha YCL-650 Clarinet');
                        $product32->setProDesc('Corps en grenadille sélectionnée. Clé de Mi grave. Finition : Argenté. Bec Yamaha 4C et étui rigide inclus.');
                        $product32->setProPriceHT(1499);
                        $product32->setProActive(true);
                        $product32->setProRef('yycl5012');
                        $product32->setProPictureName('Yamaha_YCL_650_Clarinet.jpg');
                        $product32->setSubcategory($subcategoryClarinettes);
                        $product32->setSuppliers($supplier2);
                        $manager->persist($product32);

                        $product33 = new product();
                        $product33->setProName('Selmer CL211 Clarinet');
                        $product33->setProDesc('Corps en grenadille sélectionnée. Clé de Mi grave. Finition : Argenté. Bec Selmer HS* et étui rigide inclus.');
                        $product33->setProPriceHT(1890);
                        $product33->setProActive(true);
                        $product33->setProRef('scls891');
                        $product33->setProPictureName('Selmer_CL211_Clarinet.jpg');
                        $product33->setSubcategory($subcategoryClarinettes);
                        $product33->setSuppliers($supplier1);
                        $manager->persist($product33);

                $subcategoryTrombones = new SubCategory();
                $subcategoryTrombones->setSubName('Trombones');
                $subcategoryTrombones->setSubPictureName('trombones.jpg');
                $subcategoryTrombones->setCategorys($categoryVents);
                $manager->persist($subcategoryTrombones);

                                //
                                $product34 = new Product();
                                $product34->setProName('Yamaha YSL-354 Trombone');
                                $product34->setProDesc('Trombone à coulisse standard. Finition : Laiton. Embouchure Yamaha 48 et étui rigide inclus.');
                                $product34->setProPriceHT(899);
                                $product34->setProActive(true);
                                $product34->setProRef('yysl354');
                                $product34->setProPictureName('Yamaha_YSL_354_Trombone.jpg');
                                $product34->setSubcategory($subcategoryTrombones);
                                $product34->setSuppliers($supplier2);
                                $manager->persist($product34);

                                $product35 = new Product();
                                $product35->setProName('Jupiter JSL-432 Trombone');
                                $product35->setProDesc('Trombone à coulisse standard. Finition : Laiton. Embouchure Jupiter 12C et étui rigide inclus.');
                                $product35->setProPriceHT(689);
                                $product35->setProActive(true);
                                $product35->setProRef('jjsl432');
                                $product35->setProPictureName('Jupiter_JSL_432_Trombone.jpg');
                                $product35->setSubcategory($subcategoryTrombones);
                                $product35->setSuppliers($supplier1);
                                $manager->persist($product35);

                                $product36 = new Product();
                                $product36->setProName('Bach TB301 Trombone');
                                $product36->setProDesc('Trombone à coulisse standard. Finition : Laiton. Embouchure Bach 12C et étui rigide inclus.');
                                $product36->setProPriceHT(799);
                                $product36->setProActive(true);
                                $product36->setProRef('bbach301');
                                $product36->setProPictureName('Bach_TB301_Trombone.jpg');
                                $product36->setSubcategory($subcategoryTrombones);
                                $product36->setSuppliers($supplier3);
                                $manager->persist($product36);

                // category
                $categorySono = new Category();
                $categorySono->setCatName('Sono');
                $categorySono->setCatPictureName('sono.jpg');
                $manager->persist($categorySono);

                        //subcategories
                        $subcategoryMicro = new SubCategory();
                        $subcategoryMicro->setSubName('Micro');
                        $subcategoryMicro->setSubPictureName('micro.jpg');
                        $subcategoryMicro->setCategorys($categorySono);
                        $manager->persist($subcategoryMicro);

                        //
                            $product37 = new Product();

                            $product37->setProName('Microphone Professionnel Studio XYZ-1000');
                            $product37->setProDesc('Microphone de studio haut de gamme avec une réponse en fréquence étendue et une sensibilité élevée. Idéal pour l\'enregistrement vocal et instrumental en studio professionnel.');
                            $product37->setProPriceHT(499.99);
                            $product37->setProActive(true);
                            $product37->setProRef('MSXYZ1000');
                            $product37->setProPictureName('microphone_xyz_1000.jpg');
                            $product37->setSubcategory($subcategoryMicro);
                            $product37->setSuppliers($supplier1);
                            $manager->persist($product37);
                        
                            $product38 = new Product();
                        
                            $product38->setProName('Microphone à Condensateur StudioPro-2000');
                            $product38->setProDesc('Un microphone à condensateur de qualité professionnelle offrant une clarté exceptionnelle et une reproduction sonore précise. Parfait pour les enregistrements vocaux et les instruments acoustiques.');
                            $product38->setProPriceHT(349.99);
                            $product38->setProActive(true);
                            $product38->setProRef('MSCP2000');
                            $product38->setProPictureName('microphone_studiopro_2000.jpg');
                            $product38->setSubcategory($subcategoryMicro);
                            $product38->setSuppliers($supplier2);
                            $manager->persist($product38);
                        
                            $product39 = new Product();
                        
                            $product39->setProName('Microphone Dynamique StudioTech-500');
                            $product39->setProDesc('Un microphone dynamique robuste conçu pour capturer des performances vocales et instrumentales avec une excellente isolation des bruits environnants. Idéal pour les studios de musique et les environnements d\'enregistrement professionnels.');
                            $product39->setProPriceHT(199.99);
                            $product39->setProActive(true);
                            $product39->setProRef('MSDT500');
                            $product39->setProPictureName('microphone_studiotech_500.jpg');
                            $product39->setSubcategory($subcategoryMicro);
                            $product39->setSuppliers($supplier3);
                            $manager->persist($product39);

                        $subcategoryEnceintes = new SubCategory();
                        $subcategoryEnceintes->setSubName('Enceintes de sonorisation');
                        $subcategoryEnceintes->setSubPictureName('enceintes.jpg');
                        $subcategoryEnceintes->setCategorys($categorySono);
                        $manager->persist($subcategoryEnceintes);

                                //

                            $product40 = new Product();
                            
                            $product40->setProName('Enceinte de Studio Professionnelle ProSound-1000');
                            $product40->setProDesc('Enceinte de studio professionnelle offrant une reproduction sonore haute fidélité avec une réponse en fréquence étendue. Parfaite pour le mixage et la production musicale en studio.');
                            $product40->setProPriceHT(799.99);
                            $product40->setProActive(true);
                            $product40->setProRef('ESPP1000');
                            $product40->setProPictureName('enceinte_prosound_1000.jpg');
                            $product40->setSubcategory($subcategoryEnceintes);
                            $product40->setSuppliers($supplier1);
                            $manager->persist($product40);
                            
                            $product41 = new Product();
                            
                            $product41->setProName('Enceinte de Monitoring StudioTech-2000');
                            $product41->setProDesc('Enceinte de monitoring professionnelle dotée d\'une conception bi-amplifiée et de transducteurs de qualité supérieure pour une reproduction sonore précise. Idéale pour le mixage et la production en studio.');
                            $product41->setProPriceHT(1199.99);
                            $product41->setProActive(true);
                            $product41->setProRef('EMST2000');
                            $product41->setProPictureName('enceinte_studiotech_2000.jpg');
                            $product41->setSubcategory($subcategoryEnceintes);
                            $product41->setSuppliers($supplier2);
                            $manager->persist($product41);
                            
                            $product42 = new Product();
                            
                            $product42->setProName('Enceinte de Monitoring StudioPro-3000');
                            $product42->setProDesc('Enceinte de monitoring professionnelle haut de gamme offrant une reproduction sonore exceptionnelle et une réponse en fréquence précise. Parfaite pour le mastering et la post-production en studio.');
                            $product42->setProPriceHT(1699.99);
                            $product42->setProActive(true);
                            $product42->setProRef('EMSP3000');
                            $product42->setProPictureName('enceinte_studiopro_3000.jpg');
                            $product42->setSubcategory($subcategoryEnceintes);
                            $product42->setSuppliers($supplier3);
                            $manager->persist($product42);

                        $subcategoryTables = new SubCategory();
                        $subcategoryTables->setSubName('Tables de mixage');
                        $subcategoryTables->setSubPictureName('tables.jpg');
                        $subcategoryTables->setCategorys($categorySono);
                        $manager->persist($subcategoryTables);

                            $product43 = new Product();

                            $product43->setProName('Table de Mixage StudioPro-3000');
                            $product43->setProDesc('Table de mixage professionnelle dotée de fonctionnalités avancées pour un contrôle précis du mixage en studio. Offre une qualité audio exceptionnelle et une fiabilité accrue pour répondre aux besoins des professionnels.');
                            $product43->setProPriceHT(1799.99);
                            $product43->setProActive(true);
                            $product43->setProRef('TMSRP3000');
                            $product43->setProPictureName('table_mixage_studiopro_3000.jpg');
                            $product43->setSubcategory($subcategoryTables);
                            $product43->setSuppliers($supplier1);
                            $manager->persist($product43);
                            
                            $product44 = new Product();
                            
                            $product44->setProName('Table de Mixage Numérique StudioTech-4000');
                            $product44->setProDesc('Table de mixage numérique professionnelle avec une interface conviviale et des fonctionnalités avancées pour une production musicale créative. Dispose de nombreuses entrées/sorties et de capacités de routage flexibles.');
                            $product44->setProPriceHT(2999.99);
                            $product44->setProActive(true);
                            $product44->setProRef('TMNST4000');
                            $product44->setProPictureName('table_mixage_studiotech_4000.jpg');
                            $product44->setSubcategory($subcategoryTables);
                            $product44->setSuppliers($supplier2);
                            $manager->persist($product44);
                            
                            $product45 = new Product();
                            
                            $product45->setProName('Table de Mixage Analogique ProSound-5000');
                            $product45->setProDesc('Table de mixage analogique professionnelle avec une conception robuste et des composants de haute qualité pour une performance audio exceptionnelle. Idéale pour les studios d\'enregistrement et les environnements de production.');
                            $product45->setProPriceHT(1299.99);
                            $product45->setProActive(true);
                            $product45->setProRef('TMAPS5000');
                            $product45->setProPictureName('table_mixage_prosound_5000.jpg');
                            $product45->setSubcategory($subcategoryTables);
                            $product45->setSuppliers($supplier3);
                            $manager->persist($product45);

                                                                    //add relation user/adress
                                                                        $user[1]->addYe($adress1);
                                                                        $user[2]->addYe($adress2);
                                                                        $user[3]->addYe($adress3);
                                                                        for ($i = 4; $i <= 25; $i++) {
                                                                            $user[$i]->addYe($address[$i]);
                                                                        }
                    
                                                                        $prouser[1]->addYe($adress4);
                                                                        $prouser[2]->addYe($adress5);
                                                                        $prouser[3]->addYe($adress6);
                                                                        for ($i = 4; $i <= 25; $i++) {
                                                                            $prouser[$i]->addYe($proaddress[$i]);
                                                                        }

                                                                    //

                        //generation commande client particulier

                        for ($i = 1; $i <= 226; $i++) {
                            var_dump("creation commande particulier ". $i);
                            $userset = [$user[1],$user[2],$user[3],$user[4],$user[5],$user[6],$user[7],$user[8],$user[9],$user[10],$user[11],$user[12],$user[13],$user[14],$user[15],$user[16],$user[17],$user[18],$user[19],$user[20],$user[21],$user[22],$user[23],$user[24]];
                            $productset = [
                                $product1, $product2, $product3, $product4, $product5,
                                $product6, $product7, $product8, $product9, $product10,
                                $product11, $product12, $product13, $product14, $product15,
                                $product16, $product17, $product18, $product19, $product20,
                                $product21, $product22, $product23, $product24, $product25,
                                $product26, $product27, $product28, $product29, $product30,
                                $product31, $product32, $product33, $product34, $product35,
                                $product36, $product37, $product38, $product39, $product40,
                                $product41, $product42, $product43, $product44, $product45
                            ];
                            $usernombre = rand(0,23);
                            $productnombre = rand(0,44);
                            $quantityboucle = rand(1,5);

                            $date_j = new \DateTime();

                            $date_client_commande = $this->date_gen_ant($date_j);
                            // $date_client_facturation = $date_client_commande;
                            $date_client_expediction = $this->date_gen_sup($date_client_commande);
                            $date_client_livraison_estime = $this->date_gen_sup($date_client_expediction);
                            $date_client_livraison = $this->date_gen_sup($date_client_livraison_estime);

                            $adress_get = $userset[$usernombre]->getYes();

                            $num_adress = $adress_get[0]->getAdrNumber();
                            $rue_adress = $adress_get[0]->getAdrStreet();
                            $zip_adress = $adress_get[0]->getAdrZipCode();
                            $city_adress = $adress_get[0]->getAdrCity();
                            $addinfo_adress = $adress_get[0]->getAdrAddInfo();

                            $adress_user_get = "$num_adress $rue_adress $zip_adress $city_adress $addinfo_adress ";
                            
                            $order[$i] = new Orders();
                            
                                $order[$i]->setOrdRef(0000 . $i);
                                $order[$i]->setOrdReduction(rand(0, 10));
                                $order[$i]->setOrdClientCoefficient($coeficient_base);
                                $order[$i]->setOrdAdressDelivery($adress_user_get);
                                $order[$i]->setOrdAdressBilling($adress_user_get);
                                $order[$i]->setOrdRebBill("Fact00" . $i);
                                $order[$i]->setOrdDateBill($date_client_commande);
                                $order[$i]->setOrdStatusBill(rand(1, 3));
                                $order[$i]->setUsers($userset[$usernombre]);
                            
                            $delivery[$i] = new Delivery();
                            
                                $delivery[$i]->setDelDateExped($date_client_expediction);
                                $delivery[$i]->setDelDatePlannedDelivery($date_client_livraison_estime);
                                $delivery[$i]->setDelDateDeliveryClient($date_client_livraison);
                                $delivery[$i]->setOrders($order[$i]);
                            
                            $productorder[$i] = new ProductOrders();
                            
                                    $productorder[$i]->setProOrdProductQuantity($quantityboucle);
                                    $productorder[$i]->setProOrdNameProduct($productset[$productnombre]->getProName());
                                    $productorder[$i]->setProOrdPriceUht($productset[$productnombre]->getProPriceHT()); 
                                    $productorder[$i]->setProduct($product1);
                                    $productorder[$i]->setOrders($order[$i]);
                            
                            $productdelivery[$i] = new ProductDelivery();
                            
                                    $productdelivery[$i]->setProDelProductQuantity($quantityboucle); 
                                    $productdelivery[$i]->setProduct($productset[$productnombre]);
                                    $productdelivery[$i]->setDelivery($delivery[$i]);
                            
                                    $prixarticle = $productset[$productnombre]->getProPriceHT();
                                    $tva = 1.20;
                            
                                    $order[$i]->setOrdPrixTotal($this->calprixtotal($quantityboucle,$coeficient_base,$prixarticle,$tva));
                            
                                    $manager->persist($order[$i]);
                                    $manager->persist($delivery[$i]);
                                    $manager->persist($productorder[$i]);
                                    $manager->persist($productdelivery[$i]);
                                }

                        //generation commande client pro
                                        
                        for ($i = 1; $i <= 845; $i++) {
                            var_dump("creation commande pro ".$i);
                            $userset = [$prouser[1],$prouser[2],$prouser[3],$prouser[4],$prouser[5],$prouser[6],$prouser[7],$prouser[8],$prouser[9],$prouser[10],$prouser[11],$prouser[12],$prouser[13],$prouser[14],$prouser[15],$prouser[16],$prouser[17],$prouser[18],$prouser[19],$prouser[20],$prouser[21],$prouser[22],$prouser[23],$prouser[24],$prouser[25]];
                            $productset = [
                                $product1, $product2, $product3, $product4, $product5,
                                $product6, $product7, $product8, $product9, $product10,
                                $product11, $product12, $product13, $product14, $product15,
                                $product16, $product17, $product18, $product19, $product20,
                                $product21, $product22, $product23, $product24, $product25,
                                $product26, $product27, $product28, $product29, $product30,
                                $product31, $product32, $product33, $product34, $product35,
                                $product36, $product37, $product38, $product39, $product40,
                                $product41, $product42, $product43, $product44, $product45
                            ];
                            $usernombre = rand(0,24);
                            $productnombre = rand(0,44);
                            $quantityboucle = rand(1,12);


                            $date_j = new \DateTime();

                        $date_client_commande = $this->date_gen_ant($date_j);
                            $date_client_expediction = $this->date_gen_sup($date_client_commande);
                                $date_client_livraison_estime = $this->date_gen_sup($date_client_expediction);
                                    $date_client_livraison = $this->date_gen_sup($date_client_livraison_estime);
                                        $date_client_facturation = $this->date_gen_sup($date_client_livraison);

                            $adress_get = $userset[$usernombre]->getYes();

                            $num_adress = $adress_get[0]->getAdrNumber();
                            $rue_adress = $adress_get[0]->getAdrStreet();
                            $zip_adress = $adress_get[0]->getAdrZipCode();
                            $city_adress = $adress_get[0]->getAdrCity();
                            $addinfo_adress = $adress_get[0]->getAdrAddInfo();

                            $adress_user_get = "$num_adress $rue_adress $zip_adress $city_adress $addinfo_adress ";

                            $order[$i] = new Orders();
                            
                                $order[$i]->setOrdRef(0000 . $i);
                                $order[$i]->setOrdReduction(rand(0, 10));
                                $order[$i]->setOrdClientCoefficient($coeficient_base);
                                $order[$i]->setOrdAdressDelivery($adress_user_get);
                                $order[$i]->setOrdAdressBilling($adress_user_get);
                                $order[$i]->setOrdRebBill("Fact00" . $i);
                                $order[$i]->setOrdDateBill($date_client_facturation);
                                $order[$i]->setOrdStatusBill(rand(1, 3));
                                $order[$i]->setUsers($userset[$usernombre]);
                            
                            $delivery[$i] = new Delivery();
                            
                                $delivery[$i]->setDelDateExped($date_client_expediction);
                                $delivery[$i]->setDelDatePlannedDelivery($date_client_livraison_estime);
                                $delivery[$i]->setDelDateDeliveryClient($date_client_livraison);
                                $delivery[$i]->setOrders($order[$i]);
                            
                            $productorder[$i] = new ProductOrders();
                            
                                    $productorder[$i]->setProOrdProductQuantity($quantityboucle);
                                    $productorder[$i]->setProOrdNameProduct($productset[$productnombre]->getProName()); 
                                    $productorder[$i]->setProOrdPriceUht($productset[$productnombre]->getProPriceHT()); 
                                    $productorder[$i]->setProduct($product1);
                                    $productorder[$i]->setOrders($order[$i]);
                            
                            $productdelivery[$i] = new ProductDelivery();
                            
                                    $productdelivery[$i]->setProDelProductQuantity($quantityboucle); 
                                    $productdelivery[$i]->setProduct($productset[$productnombre]);
                                    $productdelivery[$i]->setDelivery($delivery[$i]);
                            
                                    $coeficient_base = $userset[$usernombre]->getUserCompanyCoefficient();
                                    $prixarticle = $productset[$productnombre]->getProPriceHT();
                                    $tva = 1.20;
                            
                                    $order[$i]->setOrdPrixTotal($this->calprixtotal($quantityboucle,$coeficient_base,$prixarticle,$tva));
                            
                                    $manager->persist($order[$i]);
                                    $manager->persist($delivery[$i]);
                                    $manager->persist($productorder[$i]);
                                    $manager->persist($productdelivery[$i]);
                                }
  
        // Send data
        $manager->flush();
    }
}
