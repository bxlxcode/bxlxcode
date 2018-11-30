<?php

namespace App\Controller;

use App\Repository\PictureCategoryTranslationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPictureCategoryTranslationController extends AbstractController
{
    /**
     * @Route("/admin/picture/category/translation", name="picture_category_translation")
     */
    public function index(PictureCategoryTranslationRepository $pictureCategoryTranslationRepository)
    {
        $results = $pictureCategoryTranslationRepository->findAll();

        return $this->render('picture_category_translation/index.html.twig', [
            'results' => $results,
        ]);
    }
}
