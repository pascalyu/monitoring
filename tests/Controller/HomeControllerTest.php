<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    public function testHomePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testDisplayWelcomePage(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');
        $this->assertSelectorTextContains("h1","Bienvenue sur mon site de monitoring");
    }

}
