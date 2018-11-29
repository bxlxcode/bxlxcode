<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\LanguageType;
use App\Repository\LanguageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminLanguageController extends AbstractController
{
    /**
     * @Route("/admin/language", name="admin_language")
     */
    public function index(LanguageRepository $languageRepository)
    {
        $results = $languageRepository->findAll();
        return $this->render('admin_language/index.html.twig', [
            'results' => $results
        ]);
    }

    /**
     * @Route("/admin/language/add", name="admin_language_add")
     */
    public function add(Request $request, ObjectManager $objectManager)
    {

        $language = new Language();
        $language->setCreatedAt(new \DateTime('now'))
                    ->setUpdatedAt(new \DateTime('now'));

        $form = $this->createForm(LanguageType::class, $language);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectManager->persist($language);
            $objectManager->flush();
        }

        return $this->render('admin_language/add.html.twig', [
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("/admin/language/{id}/edit/", name="admin_language_edit")
     */

    public function edit(Request $request, ObjectManager $objectManager, Language $language)
    {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $language->setUpdatedAt(new \DateTime('now'));
            $objectManager->persist($language);
            $objectManager->flush();
        }

        return $this->render('admin_language/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
