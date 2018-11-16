<?php

namespace App\Controller;

use App\Entity\WebSetting;
use App\Form\WebSettingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class WebSettingController extends AbstractController
{
    /**
     * @Route("/web-setting", name="sb.web_setting")
     */
    public function index(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $webSetting = $entityManager->getRepository(WebSetting::class)->findOneBy([]);
        $webSetting = !empty($webSetting) ? $webSetting : new WebSetting();
        $form = $this->createForm(WebSettingType::class, $webSetting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $webSetting = $form->getData();

            $entityManager->persist($webSetting);
            $entityManager->flush();
        }

        return $this->render('sb/web_setting/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
