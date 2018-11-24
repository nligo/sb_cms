<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="sb.user_index", methods="GET")
     */
    public function index(UserRepository $userRepository,Request $request,PaginatorInterface $paginator): Response
    {

        $search = $request->query->all();
        $users = $userRepository->findAll();
        $pagination = $paginator->paginate(
            $users,
            $search['page'] ?? 1,
            10
        );
        return $this->render('sb/user/index.html.twig', [
            'pagination' => $pagination,
            'search' => $search
        ]);
    }

    /**
     * @Route("/new", name="sb.user_new", methods="GET|POST")
     */
    public function new(Request $request,EventDispatcherInterface $dispatcher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dispatcher->dispatch(User::ON_PRE_CREATED, new GenericEvent($user));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('sb.user_index');
        }

        return $this->render('sb/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sb.user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('sb/user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="sb.user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user,EventDispatcherInterface $dispatcher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dispatcher->dispatch(User::ON_PRE_CREATED, new GenericEvent($user));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sb.user_index', ['id' => $user->getId()]);
        }

        return $this->render('sb/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sb.user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('sb.user_index');
    }
}
