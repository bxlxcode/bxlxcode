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
    }
}