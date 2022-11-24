<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {   
        foreach (CategoryFixtures::CATEGORIES as $category) {   
            for ($i=1; $i < 6 ;$i++) {
                $program = new Program();
                $program->setTitle("Le film numéro ".$i." de la catégorie ".$category);
                $program->setSynopsis("C'est l'histoire ".$category." d'une fille...");
                $program->setCategory($this->getReference("category_" . $category));
                $manager->persist($program);
            }  
        }
            $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
