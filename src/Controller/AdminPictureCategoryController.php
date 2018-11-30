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

                $pictureCategoryTranslation->setCreatedAt(new \DateTime('now'))
                                            ->setUpdatedAt(new \DateTime('now'))
                                            ->setName("")
                                            ->setDescription("")
                                            ->setIsTranslated(true)
                                            ->addPictureCategory($pictureCategory)
                                            ->addLanguageAvailable($pictureCategory->getLanguageAvailable()->get($res));

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
                    ->setName("")
                    ->setDescription("")
                    ->setIsTranslated(true)
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
    public function delete() {

    }

    public function backup() {
        /*
        $newLanguage = new ArrayCollection();
        $currentLanguage = new ArrayCollection();
        $nouvellesLangues = new ArrayCollection();

        // as $key => $value
        // localiser les traductions existantes
        foreach ($pictureCategory->getPictureCategoryTranslations() as $translations) {
            foreach ($translations->getLanguageAvailable() as $langue) {
                $currentLanguage->add($langue->getId());
            }
        }

        dump($currentLanguage);

        // afficher les modifications qui sont faites dans des champs
        $uow = $entityManager->getUnitOfWork();
        $uow->computeChangeSets();
        $changeset = $uow->getEntityChangeSet($pictureCategory);

        // afficher les modifications qui sont faites dans une relation
        $uows = $entityManager->getUnitOfWork();
        $uows->computeChangeSets();
        $changesetss = $uows->getScheduledEntityUpdates($pictureCategory);

        // localiser les nouveaux ajouts d'ids /// toto = object = Language = langueid
        foreach ($changesetss as $test) {
            foreach ($test->getLanguageAvailable()->getValues() as $toto) {
                // dump($toto->getId());
                $newLanguage->add($toto->getId());
                $nouvellesLangues->add($toto);
            }
        }

        dump($newLanguage);

        // comparer les values
        $result = array_diff($newLanguage->getValues(), $currentLanguage->getValues());
        dump($result);

        dump($nouvellesLangues);


        // ajouter les traductions ici pour les nouvelles langues cochées

        //$objectManager->persist($pictureCategory);
        //$objectManager->flush();
        // return $this->redirectToRoute('admin_picture_category');
    */
        }
}
