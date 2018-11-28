<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Entity\LanguageAvailable;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\CategoryTranslationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/add", name="category_add")
     */

    public function add(Request $request, ObjectManager $objectManager) {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $objectManager->persist($category);

            $objectManager->flush();

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

        return $this->render('category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_edit")
     */

    public function edit(Request $request, ObjectManager $objectManager, Category $category, EntityManagerInterface $entityManager) {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        // ce formulaire ne traite pas les mises à jour des traductions
        if ($form->isSubmitted() && $form->isValid()) {


            // afficher les modifications qui sont faites dans des bêtes champs, mais pas dans la relation
            $uow = $entityManager->getUnitOfWork();
            $uow->computeChangeSets();
            $origine = $uow->getEntityChangeSet($category);
            dump($origine);

            // affiche les modifications qui sont faites dans la reation
            $second = $uow->getScheduledCollectionUpdates();
            dump($second);

            $objectManager->persist($category);
            $objectManager->flush();
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/show", name="category_show")
     */

    public function show(Category $category) {

        // dump($category->getLanguageAvailable()->getValues());
        //// dump($categoryTranslationRepository->findOneBylanguageAvailable('languageAvailable',$category->getLanguageAvailable()));

        //dump($category->getLanguageSource()->getId());
        //dump($category->getLanguageAvailable()->getValues()); // tableau des traductions disponibles

        dump($category->getCategoryTranslations()->getValues()); // tableau des traductions

        // on affiche toutes les traductions d'un contenu

        foreach ($category->getLanguageAvailable()->getKeys() as $totot) {
            echo $category->getLanguageAvailable()->get($totot)->getName();
            echo "</br>";
        }

        echo "</br>";

        foreach ($category->getCategoryTranslations()->getKeys() as $kiss) {

            echo $kiss;
            echo $category->getCategoryTranslations()->get($kiss)->getName();
            echo " ------------ ";
            echo $category->getCategoryTranslations()->get($kiss)->getDescription();
            echo "</br>";

        }

        return $this->render('category/show.html.twig', [
            'result' => $category,
        ]);

    }

    /**
     * @Route("/delete", name="category_delete")
     */

    public function delete() {

    }



    // use it
    public function bakcup (Request $request, ObjectManager $objectManager, Category $category = null)
    {

        $newcategory = false;

        if (!$category) {
            $category = new Category();
            $newcategory = true;
        }




        foreach ($category->getLanguageAvailable()->getKeys() as $dispo) {
           $name = $category->getLanguageAvailable()->get($dispo)->getName();
           echo "La valeur est $name";
           echo "</br>";
        }



        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectManager->persist($category);
            $objectManager->flush();

            // créer une traduction ici uniquement quand c'est un nouvel ajout
            // la modification n'est pas encore traitée dans ce controller

            if ($newcategory = false) {

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
            // modifications
            else {

            }

        }

        return $this->render('category/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
