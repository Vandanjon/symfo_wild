<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach (CategoryFixtures::CATEGORIES as $category) {   
            $program = new Program();
            $program->setTitle("Le meilleur film " . $category);
            $program->setSynopsis("C'est l'histoire ".$category." d'une fille...");
            $program->setCategory($this->getReference("category_" . $category));
            
            $manager->persist($program);
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
