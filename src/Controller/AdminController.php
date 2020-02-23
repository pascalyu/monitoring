<?php

namespace App\Controller;

use App\Entity\Website;
use App\Form\WebsiteType;
use App\Repository\WebsiteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(WebsiteRepository $websiteRepository)
    {

        $websites = $websiteRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'websites' => $websites,
        ]);
    }

    /**
     * @Route("/admin/new", name="new")
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {

        $website = new Website();
        $form = $this->createForm(WebsiteType::class, $website);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $website->setCreatedAt(new DateTime());
            $manager->persist($website);
            $manager->flush();

            $this->addFlash("success", "le site a bien été enregistré");
            return $this->redirectToRoute("home");
        }
        return $this->render('admin/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/{id}/remove", name="remove")
     */
    public function remove(Website $website, EntityManagerInterface $manager)
    {
        $manager->remove($website);
        $manager->flush();
        $this->addFlash("warning", "le site a bien été suprimé");
        return $this->redirectToRoute("admin");
    }


    /**
     * @Route("/admin/{id}/edit", name="edit")
     */
    public function edit(Website $website, EntityManagerInterface $manager,Request $request)
    {
        $form = $this->createForm(WebsiteType::class, $website);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($website);
            $manager->flush();

            $this->addFlash("success", "le site a bien été edité");
            return $this->redirectToRoute("admin");
        }
        return $this->render('admin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
