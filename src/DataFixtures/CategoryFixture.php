<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $obj = new Category();
        $obj
            ->setName('sb.cms test')
            ->setIsPublic(true);
        $manager->persist($obj);
        $manager->flush();
    }
}
