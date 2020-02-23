<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Website;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function getWebsiteEntity(String $url, String $name)
    {
        return (new Website())
            ->setUrl($url)
            ->setName($name)
            ->setCreatedAt(new DateTime());
    }
    public function load(ObjectManager $manager)
    {


        $admin = new User();
        $admin->setEmail("pascalyut@gmail.com");
        
        $admin->setRoles(["ROLE_ADMIN"]);
        $encoded=$this->encoder->encodePassword($admin,"0000");
        $admin->setPassword($encoded);
   
        $manager->persist($admin);
        $manager->persist($this->getWebsiteEntity("www.google.com", "Google"));
        $manager->persist($this->getWebsiteEntity("www.youtube.com", "youtube"));
        $manager->persist($this->getWebsiteEntity("www.9gag.com", "9gag"));
        $manager->persist($this->getWebsiteEntity("www.symfony.com", "Symfony"));
        $manager->persist($this->getWebsiteEntity("www.test.com", "test"));

        $manager->persist($this->getWebsiteEntity("www.testerror.comquiesxi", "test error"));

        $manager->flush();
    }
}
