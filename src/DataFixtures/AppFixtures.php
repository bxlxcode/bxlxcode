<?php
namespace App\DataFixtures;
use App\Entity\Category;
use App\Entity\CategoryTranslation;
use App\Entity\LanguageAvailable;
use App\Entity\LanguageSource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $arrayCollection = new ArrayCollection();
        for ($i = 0; $i < 6; $i++) {
            for ($b = 0; $b < 1; $b++) {
                // création des langues disponibles
                $languageAvailable = new LanguageAvailable();
                $languageAvailable->setName($faker->country);
                $languageAvailable->setIso($faker->countryCode);
                $manager->persist($languageAvailable);
                // création des langues source
                $languageSource = new LanguageSource();
                $languageSource->setName($languageAvailable->getName());
                $languageSource->setIso($languageAvailable->getIso());
                $manager->persist($languageSource);
                $manager->flush(); // un flush ici pour avoir les id des langues
                // ajouter les langues availables aux tableau
                $arrayCollection->add($languageAvailable);
            }
            // création des catégories
            $c = new Category();
            $c->setName($faker->company);
            $c->setDescription($faker->sentence);
            // ajouter la langue current à la catégorie
            $c->setLanguageSource($languageSource);
            // Mettre la catégorie dans toutes les langues disponibles dans le tableau
            foreach ($arrayCollection->getKeys() as $res) {
                $c->addLanguageAvailable($arrayCollection->get($res));
            }
            $manager->persist($c);
            $manager->flush();    // un flush ici pour avoir déjà un id de la catégorie
            foreach ($arrayCollection->getKeys() as $res) {
                // création d'une traduction
                $categoryTranslation = new CategoryTranslation();
                $categoryTranslation->setName('Name en '. $arrayCollection->get($res)->getName());
                $categoryTranslation->setDescription('Description en '. $arrayCollection->get($res)->getName());
                $categoryTranslation->addLanguageAvailable($arrayCollection->get($res));
                $categoryTranslation->addCategory($c);
                $manager->persist($categoryTranslation);
                $manager->flush();
            }
        }
    }
}