<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="sb_index")
     */
    public function index()
    {
        return $this->render('sb/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
