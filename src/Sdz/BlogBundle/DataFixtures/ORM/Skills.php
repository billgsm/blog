<?php

namespace Sdz\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sdz\BlogBundle\Entity\Skill;

class Skills implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array('Doctrine', 'Form', 'Twig');

        foreach($names as $i => $name)
        {
            $skills_list[$i] = new Skill();
            $skills_list[$i]->setName($name);

            $manager->persist($skills_list[$i]);
        }

        $manager->flush();
    }
}
