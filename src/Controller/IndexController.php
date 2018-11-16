<?php

namespace App\Controller;

use App\Entity\WebSetting;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/admin", name="sb_index")
     */
    public function index()
    {
        return $this->render('sb/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    public function webSetting()
    {
       $webSetting = $this->getDoctrine()->getRepository(WebSetting::class)->findOneBy([]);
       return $webSetting;
    }
}
