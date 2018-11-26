<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LanguageSourceController extends AbstractController
{
    /**
     * @Route("/language/source", name="language_source")
     */
    public function index()
    {
        return $this->render('language_source/index.html.twig', [
            'controller_name' => 'LanguageSourceController',
        ]);
    }
}
