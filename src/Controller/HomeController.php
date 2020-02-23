<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Website;
use App\Repository\StatusRepository;
use App\Repository\WebsiteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(WebsiteRepository $websiteRepository)
    {
        $websites = $websiteRepository->findAll();

        return $this->render('home/index.html.twig', [
            'websites' => $websites,
        ]);
    }


    /**
     * @Route("/website/{id}", name="website_show")
     */
    public function showWebsite(Website $website, WebsiteRepository $websiteRepository)
    {
        return $this->render('home/show.html.twig', [
            'website' => $website,
        ]);
    }

    /**
     * @Route("/analyze", name="analyze")
     */
    public function analyze(WebsiteRepository $websiteRepository, EntityManagerInterface $manager)
    {

        $websites = $websiteRepository->findAll();

        foreach ($websites as $index => $website) {
            $url = $website->getUrl();

            $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($handle);
            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            curl_close($handle);
            $status = new Status();
            $status->setCode((string) $code);
            $status->setWebsite($website);

            $status->setCreatedAt(new DateTime());
            $manager->persist($status);
        }
        $manager->flush();
        $this->addFlash("success", "le diagnostic a bien été effectué");
        return $this->redirectToRoute("home");
    }


    /**
     * @Route("/clean", name="clean_statuses")
     */
    public function cleanStatuses(StatusRepository $statusRepository)
    {
        $statusRepository->cleanStatusesHistory();
        
        $this->addFlash("warning", "L'historique des status a bien été supprimé");
        return $this->redirectToRoute("home");
    }
}
