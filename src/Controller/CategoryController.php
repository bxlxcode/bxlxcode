<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Form\CategoryType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/", name="category_add")
     * @Route("/{id}/edit", name="category_edit")
     */

    public function action (Request $request, ObjectManager $objectManager, Category $category = null)
    {

        $newcategory = false;

        if (!$category) {
            $category = new Category();
            $newcategory = true;
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectManager->persist($category);
            $objectManager->flush();

            // créer une traduction ici uniquement quand c'est un nouvel ajout
            // la modification n'est pas encore traitée dans ce controller

            if ($newcategory = true) {

                // je récupére toutes les langues du formulaire
                foreach ($category->getLanguageAvailable()->getKeys() as $res) {

                    $categoryTranslation = new CategoryTranslation();

                    $categoryTranslation->setName($category->getName().' en ' . $category->getLanguageAvailable()->get($res)->getName());
                    $categoryTranslation->setDescription($category->getDescription().' en ' . $category->getLanguageAvailable()->get($res)->getName());
                    $categoryTranslation->addCategory($category);
                    $categoryTranslation->addLanguageAvailable($category->getLanguageAvailable()->get($res));
                    $objectManager->persist($categoryTranslation);
                }

                $objectManager->flush();
            }

        }

        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
