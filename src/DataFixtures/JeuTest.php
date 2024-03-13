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
use Symfony\Component\VarDumper\VarDumper;

class JeuTest extends Fixture
{
    //Function
    private $hasher;

    public function calprixtotal ($quantityboucle,$coeficient_base,$prixarticle,$tva ) {
        return $prixtotal = ((($prixarticle*$quantityboucle)*$coeficient_base)*$tva);
    }
            
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
            $comuser1->setRoles(['ROLE_COM']);
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
            $comuser2->setRoles(['ROLE_COM']);
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
            $comuser3->setRoles(['ROLE_COM']);
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
        
                $manager->persist($adress3);
            
            // Client Pro

                //1

                $prouser1 = new Users();
                $prouser1->setUserEmail('pro1@example.com');
                $prouser1->setRoles(['ROLE_PRO']);
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
                $prouser2->setRoles(['ROLE_PRO']);
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
                $prouser3->setRoles(['ROLE_PRO']);
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

                                                                    //add relation user/adress
                                                                        $user1->addYe($adress1);
                                                                        $user2->addYe($adress2);
                                                                        $user3->addYe($adress3);
                    
                                                                        $prouser1->addYe($adress4);
                                                                        $prouser2->addYe($adress5);
                                                                        $prouser3->addYe($adress6);

                                                                    //

                        //generation commande client particulier
                        for ($i = 1; $i <= 20; $i++) {

                            $userset = [$user1,$user2,$user3];
                            $productset = [$product1, $product2, $product3, $product4, $product5, $product6, $product7, $product8, $product9, $product10, $product11, $product12, $product13, $product14, $product15, $product16, $product17, $product18, $product19, $product20, $product21, $product22, $product23, $product24, $product25, $product26, $product27];
                            $usernombre = rand(0,2);
                            $productnombre = rand(0,26);
                            $quantityboucle = rand(1,5);

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
                                $order[$i]->setOrdDateBill(new \DateTime());
                                $order[$i]->setOrdStatusBill(rand(1, 3));
                                $order[$i]->setUsers($userset[$usernombre]); //$userset[$usernombre]
                            
                            $delivery[$i] = new Delivery();
                            
                                $delivery[$i]->setDelDateExped(new \DateTime());
                                $delivery[$i]->setDelDatePlannedDelivery(new \DateTime());
                                $delivery[$i]->setDelDateDeliveryClient(new \DateTime());
                            
                            $productorder[$i] = new ProductOrders();
                            
                                    $productorder[$i]->setProOrdProductQuantity($quantityboucle);
                                    $productorder[$i]->setProOrdNameProduct($productset[$productnombre]->getProName()); //$productset[$productnombre]->getProName()
                                    $productorder[$i]->setProOrdPriceUht($productset[$productnombre]->getProPriceHT()); //$productset[$productnombre]->getProPriceHT()
                                    $productorder[$i]->setProduct($product1); //$productset[$productnombre]
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
                                        
                        for ($i = 1; $i <= 20; $i++) {

                            $userset = [$prouser1,$prouser2,$prouser3];
                            $productset = [$product1, $product2, $product3, $product4, $product5, $product6, $product7, $product8, $product9, $product10, $product11, $product12, $product13, $product14, $product15, $product16, $product17, $product18, $product19, $product20, $product21, $product22, $product23, $product24, $product25, $product26, $product27];
                            $usernombre = rand(0,2);
                            $productnombre = rand(0,26);
                            $quantityboucle = rand(1,12);

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
                                $order[$i]->setOrdClientCoefficient($userset[$usernombre]->getUserCompanyCoefficient());
                                $order[$i]->setOrdAdressDelivery($adress_user_get);
                                $order[$i]->setOrdAdressBilling($adress_user_get);
                                $order[$i]->setOrdRebBill("Fact00" . $i);
                                $order[$i]->setOrdDateBill(new \DateTime());
                                $order[$i]->setOrdStatusBill(rand(1, 3));
                                $order[$i]->setUsers($userset[$usernombre]); //$userset[$usernombre]
                            
                            $delivery[$i] = new Delivery();
                            
                                $delivery[$i]->setDelDateExped(new \DateTime());
                                $delivery[$i]->setDelDatePlannedDelivery(new \DateTime());
                                $delivery[$i]->setDelDateDeliveryClient(new \DateTime());
                            
                            $productorder[$i] = new ProductOrders();
                            
                                    $productorder[$i]->setProOrdProductQuantity($quantityboucle);
                                    $productorder[$i]->setProOrdNameProduct($productset[$productnombre]->getProName()); //$productset[$productnombre]->getProName()
                                    $productorder[$i]->setProOrdPriceUht($productset[$productnombre]->getProPriceHT()); //$productset[$productnombre]->getProPriceHT()
                                    $productorder[$i]->setProduct($product1); //$productset[$productnombre]
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
