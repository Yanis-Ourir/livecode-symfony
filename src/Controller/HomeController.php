<?php

namespace App\Controller;

use App\Entity\Cat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $number = random_int(0, 100);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'number' => $number
        ]);
    }

    #[Route('/test', name: 'app_test')]
    public function test(): Response
    {
        $prenom = 'Chafi';

        $cat = new Cat();
        $cat->setName('felix');
        $cat->setAge(10);





        return $this->render('home/test.html.twig', [
            'prenom' => $prenom,
            'cat' => $cat
        ]);
    }
}
