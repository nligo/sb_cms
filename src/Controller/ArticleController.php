<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="sb.article.index", methods="GET")
     */
    public function index(ArticleRepository $articleRepository,CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $search = $request->query->all();
        $categories = $categoryRepository->getCategoies()->getQuery()->getResult();
        $articles =  $articleRepository->getArticles($search);
        $pagination = $paginator->paginate(
            $articles,
            $search['page'] ?? 1,
            10
        );
        return $this->render('sb/article/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories,
            'search' => $search
        ]);
    }

    /**
     * @Route("/new", name="sb.article.new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('sb.article.index');
        }

        return $this->render('sb/article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="sb.article.show", methods="GET")
     */
    public function show(Article $article): Response
    {
        return $this->render('sb/article/show.html.twig', ['info' => $article]);
    }

    /**
     * @Route("/{id}/edit", name="sb.article.edit", methods="GET|POST")
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sb.article.index', ['id' => $article->getId()]);
        }

        return $this->render('sb/article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="sb.article.delete", methods="DELETE")
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('sb.article.index');
    }
}
