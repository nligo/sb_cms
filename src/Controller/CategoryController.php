<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="sb.category_index", methods="GET")
     */
    public function index(CategoryRepository $categoryRepository,Request $request,PaginatorInterface $paginator): Response
    {

        $search = $request->query->all();
        $categories = $categoryRepository->findAll();
        $pagination = $paginator->paginate(
            $categories,
            $search['page'] ?? 1,
            10
        );
        return $this->render('sb/category/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $categories,
            'search' => $search
        ]);
    }

    /**
     * @Route("/new", name="sb.category_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('sb.category_index');
        }

        return $this->render('sb/category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sb.category_edit", methods="GET|POST")
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sb.category_index', ['id' => $category->getId()]);
        }

        return $this->render('sb/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sb.category_delete", methods="DELETE")
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('sb.category_index');
    }
}
