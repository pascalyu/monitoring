<?php

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PageControllerTest extends WebTestCase
{
    public function testHelloPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/hello');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testH1HelloPage(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/hello');
        $this->assertSelectorTextContains("h1","bienvenue sur mon site");
    }

    public function testPageAuthRestricted(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/auth');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

    }
    public function testRedirectToLogin(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/auth');
        $this->assertResponseRedirects("/login");

    }
}
