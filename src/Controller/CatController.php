<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Form\CatType;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatController extends AbstractController
{
    #[Route('/cat', name: 'app_cat')]
    public function index(CatRepository $catRepository): Response
    {
        $cats = $catRepository->findAll();

        return $this->render('cat/index.html.twig', [
            'cats' => $cats
        ]);
    }

    #[Route('/cat/{id}', name: 'app_cat_show')]
    public function show(CatRepository $catRepository, int $id): Response
    {
        $cat = $catRepository->find($id);

        return $this->render('cat/show.html.twig', [
            'cat' => $cat,
        ]);
    }


    #[Route('/add/cat', name: 'app_add_cat')]
    public function create(Request $request, CatRepository $catRepository, EntityManagerInterface $entityManager): Response
    {

        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $cat->setCreatedAt(new \DateTimeImmutable());
            $cat->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->persist($cat);
            $entityManager->flush();
        }

//        O = Objet R = Relationnal M = mapping // ça fait le lien entre vos objets et votre BDD



        return $this->render('cat/create.html.twig', [
            'formCat' => $form->createView(),
        ]);
    }


    #[Route('/cat/update/{id}', name: 'app_update_cat')]
    public function update(Request $request, CatRepository $catRepository, EntityManagerInterface $entityManager, int $id): Response
    {

        $cat = $catRepository->find($id);
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {


            $cat->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->persist($cat);
            $entityManager->flush();
        }

//        O = Objet R = Relationnal M = mapping // ça fait le lien entre vos objets et votre BDD



        return $this->render('cat/update.html.twig', [
            'formCat' => $form->createView(),
        ]);
    }


    #[Route('/cat/delete/{id}', name: 'app_cat_delete')]
    public function delete(CatRepository $catRepository, EntityManagerInterface $entityManager, int $id): Response
    {
        $cat = $catRepository->find($id);
        $entityManager->remove($cat);
        $entityManager->flush();

        return $this->redirectToRoute('app_cat');

    }


}
