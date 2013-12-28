<?php
namespace Sdz\gcBlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sdz\BlogBundle\Entity\Category;

class Categories implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Symfony2',
            'Doctrine',
            'Tutorial',
            'Event',
            'Django',
            'Python',
            'Celery',
            'Scrapy',
            'Web');

        foreach($names as $i => $name)
        {
            $categories_list[$i] = new Category();
            $categories_list[$i]->setName($name);

            $manager->persist($categories_list[$i]);
        }

        $manager->flush();
    }
}
