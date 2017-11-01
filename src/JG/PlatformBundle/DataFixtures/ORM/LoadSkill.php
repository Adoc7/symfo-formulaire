<?php

namespace JG\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JG\PlatformBundle\Entity\Skill;

class LoadSkill implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Liste des noms de compétences à ajouter
        $names = array ('PHP', 'Symphony2', 'C++', 'Java', 'Photoshop', 'Blender', 'Bloc-note');

        foreach ($names as $name){

            // On crée la compétence
            $skill = new skill();

            $skill->setName($name);

            // On la persiste
            $manager->persist($skill);

            // On déclenche l'enregistrement de toutes les catégories
            $manager->flush();

        }
    }
}
