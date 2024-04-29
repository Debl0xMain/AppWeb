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
        sleep(1);
// switch vers login
        $crawler->filter('.slider')->click();
        sleep(1);
//Log le client
        $form = $crawler->selectButton('Sign in')->form();
        $form['userEmail'] = 'particulier1@example.com';
        $form['password'] = 'admin';
    //sum le formulaire
        $crawler = $client->submit($form);
        sleep(1);

// click Vents
        $crawler = $client->clickLink('Vents');
        $crawler->filter("#btn_28");
        sleep(1);
    // refesh crawler
        $updatedCrawler = $client->refreshCrawler();

        $updatedCrawler->filter('#btn_28')->click();
//Open bash
        $updatedCrawler->filter('#shopbtn')->click();

        sleep(1);
//sup article panier
        $updatedCrawler->filter('.btn-outline-danger')->click();
        $updatedCrawler->filter('.btn-outline-danger')->click();
        sleep(2);

// click Sono
        $crawler = $client->clickLink('Sono');
        $crawler->filter("#btn_37");
        sleep(2);
        $updatedCrawler = $client->refreshCrawler();
        $updatedCrawler->filter('#btn_37')->click();
        sleep(4);
//Open bash
        $updatedCrawler->filter('#shopbtn')->click();
        sleep(2);
//ouverture du panier
        $updatedCrawler = $client->clickLink('Paiement');
        //go Paiement
        $updatedCrawler = $client->refreshCrawler();
        sleep(2);
//GOOD
        //Select condition livraison

        $myInput = $updatedCrawler->filterXPath(".//select[@id='adress_cmd_valid_livraison']//option[@value='1']");
        $myInput->click();
        sleep(200);
        $this->assertSelectorTextContains('body', 'TestUser1');
    }
}
