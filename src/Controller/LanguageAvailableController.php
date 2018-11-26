<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LanguageAvailableController extends AbstractController
{
    /**
     * @Route("/language/available", name="language_available")
     */
    public function index()
    {
        return $this->render('language_available/index.html.twig', [
            'controller_name' => 'LanguageAvailableController',
        ]);
    }
}
