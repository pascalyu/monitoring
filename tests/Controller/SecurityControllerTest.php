<?php

namespace App\tests\Controller;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{

    use FixturesTrait;
    public function testLoginPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testDisplayLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertSelectorTextContains("h1", "Se connecter");
    }

    public function testLoginWithBadCredential()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton("Se connecter")->form([
            'email' => "test@yopmail.com",
            'password' => "0000"
        ]);
        $client->submit($form);
        $this->assertResponseRedirects("/login");
        $client->followRedirect();
        $this->assertSelectorExists(".alert.alert-danger");
    }

    public function testSuccesLogin()
    {
        $this->loadFixtureFiles([__DIR__."/users.yaml"]);
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton("Se connecter")->form([
            'email' => "test@yopmail.com",
            'password' => "0000"
        ]);
        $client->submit($form);
        $this->assertResponseRedirects("/auth");
    }
}
