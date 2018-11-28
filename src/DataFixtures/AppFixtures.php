<?php
namespace App\DataFixtures;
use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Entity\Language;
use App\Entity\LanguageAvailable;
use App\Entity\LanguageSource;
use App\Entity\PictureCategory;
use App\Entity\PictureCategoryTranslation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $ac = new ArrayCollection();

        for ($a =0; $a < 6; $a++) {

            $language = new Language();

            $language->setCreatedAt(new \DateTime('now'))
                    ->setUpdatedAt(new \DateTime('now'))
                    ->setName($faker->languageCode)
                    ->setIso($faker->languageCode)
                    ->setIsPublish($faker->boolean)
                    ->setIcon('iso.icon');

            $manager->persist($language);

            $manager->flush();

            $ac->add($language);

            $pc = new PictureCategory();

            $pc->setCreatedAt(new \DateTime('now'))
                ->setUpdatedAt(new \DateTime('now'))
                ->setName($faker->colorName)
                ->setIsPublish($faker->boolean)
                ->setDescription($faker->sentence(6,true))
                ->setLanguageSource($language);

                foreach ($ac->getKeys() as $res) {
                    $pc->addLanguageAvailable($ac->get($res));
                }

                $manager->persist($pc);

                $manager->flush();


            foreach ($ac->getKeys() as $res) {
                $pictureCategoryTranslation = new PictureCategoryTranslation();
                $pictureCategoryTranslation->setCreatedAt(new \DateTime('now'))
                    ->setUpdatedAt(new \DateTime('now'))
                    ->setDescription("Description")
                    ->setName($language->getName() . " vers " .$ac->get($res)->getName() )
                    ->setIsTranslated($faker->boolean)
                    ->addLanguageAvailable($ac->get($res))
                    ->addPictureCategory($pc);

                $manager->persist($pictureCategoryTranslation);
                $manager->flush();
            }





        }
    }
}