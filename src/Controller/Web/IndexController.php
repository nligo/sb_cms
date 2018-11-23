<?php

namespace App\Controller\Web;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="web_index")
     */
    public function index(ArticleRepository $articleRepository)
    {
        $list = $articleRepository->getArticles();
        return $this->render('web/index.html.twig', [
            'list' => $list,
        ]);
    }
}
