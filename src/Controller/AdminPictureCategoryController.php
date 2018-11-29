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
                    ->setName($pictureCategory->getName())
                    ->setDescription($pictureCategory->getDescription())
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

        // toutes les traductions disponbiles
        //dump($pictureCategory->getPictureCategoryTranslations()->getValues());

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureCategory->setUpdatedAt(new \DateTime('now'));

            $newids = new ArrayCollection();
            $origineids = new ArrayCollection();

            dump($pictureCategory->getPictureCategoryTranslations()->getValues());

            //$objectManager->persist($pictureCategory);
            //$objectManager->flush();

            // afficher les modifications qui sont faites dans des bêtes champs, mais pas dans la relation
            $uow = $entityManager->getUnitOfWork();
            $uow->computeChangeSets();
            $changeset = $uow->getEntityChangeSet($pictureCategory);
            //dump($changeset);

            // afficher les modifications qui sont faites dans une relation
            $uows = $entityManager->getUnitOfWork();
            $uows->computeChangeSets();
            $changesetss = $uows->getScheduledEntityUpdates($pictureCategory);

            // localiser les nouveaux ajouts d'ids /// toto = object = Language = langueid
            foreach ($changesetss as $test) {
                foreach ($test->getLanguageAvailable()->getValues() as $toto) {
                   // dump($toto->getId());
                    $newids->add($toto->getId());
                }
            }

            dump($newids);

        }

        return $this->render('admin_picture_category/edit.html.twig', ['form' => $form->createView()]);
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
}
