<?php

namespace App\Controller;

use App\Entity\PictureCategory;
use App\Entity\PictureCategoryTranslation;
use App\Form\PictureCategoryType;
use Doctrine\Common\Persistence\ObjectManager;
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

           // modifier le code suivant par un foreach
            $pictureCategoryTranslation = new PictureCategoryTranslation();
            $pictureCategoryTranslation->setCreatedAt(new \DateTime('now'))
                ->setUpdatedAt(new \DateTime('now'))
                ->setName("test")
                ->setDescription("test")
                ->setIsTranslated(true)
                ->addPictureCategory($pictureCategory)
                ->addLanguageAvailable($pictureCategory->getLanguageSource());

            $objectManager->persist($pictureCategoryTranslation);
            $objectManager->flush();

        }

        return $this->render('admin_picture_category/add.html.twig', ['form' => $form->createView()]);
    }







































    /**
     * @Route("/admin/picture/category", name="admin_picture_category")
     */

    public function index()
    {
        return $this->render('admin_picture_category/index.html.twig');
    }

    /**
     * @Route("/admin/picture/category/{id}/show", name="admin_picture_category_show")
     */
    public function show() {

    }

    /**
     * @Route("/admin/picture/category/{id}/edit", name="admin_picture_category_edit")
     */
    public function edit() {

    }



    /**
     * @Route("/admin/picture/category/{id}/delete", name="admin_picture_category_delete")
     */
    public function delete() {

    }
}
