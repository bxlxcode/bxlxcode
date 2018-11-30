<?php

namespace App\Controller;

use App\Entity\PictureCategory;
use App\Entity\PictureCategoryTranslation;
use App\Form\PictureCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\PictureCategoryRepository;
use App\Repository\PictureCategoryTranslationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPictureCategoryController extends AbstractController
{
    /**
     * @Route("/admin/picture/category/add", name="admin_picture_category_add")
     */

    public function add(Request $request, ObjectManager $objectManager) {

        $pictureCategory = new PictureCategory();

        $pictureCategory->setCreatedAt(new \DateTime('now'))
                        ->setUpdatedAt(new \DateTime('now'));

        $form = $this->createForm(PictureCategoryType::class, $pictureCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectManager->persist($pictureCategory);
            $objectManager->flush();

            foreach ($pictureCategory->getLanguageAvailable()->getKeys() as $res) {

                $pictureCategoryTranslation = new PictureCategoryTranslation();
                $pictureCategoryTranslation->setCreatedAt(new \DateTime('now'));
                $pictureCategoryTranslation->setUpdatedAt(new \DateTime('now'));

                // vérifier la langue source et créer un enregistrement lié
                if ($pictureCategory->getLanguageSource() == $pictureCategory->getLanguageAvailable()->get($res)) {
                    $pictureCategoryTranslation->setName($pictureCategory->getName());
                    $pictureCategoryTranslation->setDescription($pictureCategory->getDescription());
                    $pictureCategoryTranslation->setIsTranslated(true);
                } else {
                    // sinon, set les autres traductions sans values
                    $pictureCategoryTranslation->setName($pictureCategory->getName());
                    $pictureCategoryTranslation->setDescription($pictureCategory->getDescription());
                    $pictureCategoryTranslation->setIsTranslated(false);
                }

                $pictureCategoryTranslation->addPictureCategory($pictureCategory);
                $pictureCategoryTranslation->addLanguageAvailable($pictureCategory->getLanguageAvailable()->get($res));

                $objectManager->persist($pictureCategoryTranslation);
                $objectManager->flush();
            }

            return $this->redirectToRoute('admin_picture_category');

        }

        return $this->render('admin_picture_category/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/admin/picture/category/{id}/edit", name="admin_picture_category_edit")
     */

    public function edit(Request $request, ObjectManager $objectManager, PictureCategory $pictureCategory, EntityManagerInterface $entityManager) {

        $form = $this->createForm(PictureCategoryType::class, $pictureCategory);
        $form->handleRequest($request);
        $pictureCategory->setUpdatedAt(new \DateTime('now'));

        if ($form->isSubmitted() && $form->isValid()) {

            $currentTranslation = new ArrayCollection();
            $newLanguage = new ArrayCollection();

            foreach ($pictureCategory->getPictureCategoryTranslations() as $translations) {
                foreach ($translations->getLanguageAvailable() as $langue) {
                    $currentTranslation->add($langue);
                }
            }

            // afficher les modifications qui sont faites dans une relation
            $uows = $entityManager->getUnitOfWork();
            $uows->computeChangeSets();
            $result = $uows->getScheduledEntityUpdates($pictureCategory);
            // localiser les nouveaux ajouts d'ids /// toto = object = Language = langueid
            foreach ($result as $test) {
                foreach ($test->getLanguageAvailable()->getValues() as $langue) {
                    $newLanguage->add($langue);
                }
            }

            // isoler les nouvelles langues ajoutées
            foreach ($newLanguage->getValues() as $remove) {
                foreach ($currentTranslation->getValues() as $current) {
                    if ($remove == $current) {
                        $newLanguage->removeElement($current);
                    }
                }
            }


            // ajouter les traductions pour chaque nouvelle langue détectée
            foreach ($newLanguage->getValues() as $value) {

                $pictureCategoryTranslation = new PictureCategoryTranslation();

                $pictureCategoryTranslation->setCreatedAt(new \DateTime('now'))
                    ->setUpdatedAt(new \DateTime('now'))
                    ->setName()
                    ->setDescription()
                    ->setIsTranslated(false)
                    ->addPictureCategory($pictureCategory)
                    ->addLanguageAvailable($value);

                $objectManager->persist($pictureCategoryTranslation);
                $objectManager->flush();
            }

            $objectManager->persist($pictureCategory);
            $objectManager->flush();

            return $this->redirectToRoute('admin_picture_category');
        }

        return $this->render('admin_picture_category/edit.html.twig', [
            'form' => $form->createView(),
            'pictureCategory' => $pictureCategory
        ]);
    }

    /**
     * @Route("/admin/picture/category", name="admin_picture_category")
     */

    public function index(PictureCategoryRepository $categoryRepository)
    {
        $results = $categoryRepository->findAll();
        return $this->render('admin_picture_category/index.html.twig', [
            'results' => $results
        ]);
    }

    /**
     * @Route("/admin/picture/category/{id}/show", name="admin_picture_category_show")
     */
    public function show(PictureCategory $pictureCategory) {

        dump($pictureCategory->getLanguageAvailable());

        return $this->render('admin_picture_category/show.html.twig',[
            'results' => $pictureCategory
        ]);
    }

    /**
     * @Route("/admin/picture/category/{id}/delete", name="admin_picture_category_delete")
     */
    public function delete(ObjectManager $objectManager, PictureCategory $pictureCategory) {

        // supprimer les traductions

        // supprimer l'objet en question
        // $objectManager->remove($pictureCategory);
        //$objectManager->flush();

        // return $this->redirectToRoute('admin_picture_category');

        return $this->render('admin_picture_category/delete.html.twig');
    }
}
