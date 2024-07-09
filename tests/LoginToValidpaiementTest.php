<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class LoginToValidpaiementTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient();
        
        $crawler = $client->request('GET', '/');

// Selecion le btn login Inscription
        $crawler->filter('.btnicon')->click();
        sleep(5);
// switch vers login
        $crawler->filter('.slider')->click();
        sleep(5);
//Log le client
        $form = $crawler->selectButton('Sign in')->form();
        $form['userEmail'] = 'particulier1@example.com';
        $form['password'] = 'admin';
    //sum le formulaire
        $crawler = $client->submit($form);
        sleep(5);

// click Vents
        $crawler = $client->clickLink('Vents');
        $crawler->filter("#btn_28");
        sleep(5);
    // refesh crawler
        $updatedCrawler = $client->refreshCrawler();

        $updatedCrawler->filter('#btn_28')->click();
//Open bash
        $updatedCrawler->filter('#shopbtn')->click();

        sleep(5);
//sup article panier
        $updatedCrawler->filter('.btn-outline-danger')->click();
        $updatedCrawler->filter('.btn-outline-danger')->click();
        sleep(5);

// click Sono
        $crawler = $client->clickLink('Sono');
        $crawler->filter("#btn_37");
        sleep(5);
        $updatedCrawler = $client->refreshCrawler();
        $updatedCrawler->filter('#btn_37')->click();
        sleep(5);
//Open bash
        $updatedCrawler->filter('#shopbtn')->click();
        sleep(5);
//ouverture du panier
        $updatedCrawler = $client->clickLink('Paiement');
        //go Paiement
        $updatedCrawler = $client->refreshCrawler();
        sleep(5);
        //Select condition livraison

        $myInput = $updatedCrawler->filterXPath(".//select[@id='adress_cmd_valid_livraison']//option[@value='1']");
        $myInput->click();
        sleep(5);

        $client->executeScript("document.querySelector('#paiement_btn').click()");
        $client->executeScript("document.querySelector('#request_valid_paiement').click()");
        sleep(3);
        //changement de fenetre
        $handles = $client->getWindowHandles();
        $client->switchTo()->window(end($handles));
        sleep(5);
        $client->executeScript("document.querySelector('#send_data_paiement').click()");
        sleep(10);
        //retour a la fenetre
        $handles = $client->getWindowHandles();
        $client->switchTo()->window(end($handles));

        $client->waitFor('#Accueil', 30);

        sleep(5);
        //GOOD

        $this->assertSelectorTextContains('body', 'Accueil');
    }
}
