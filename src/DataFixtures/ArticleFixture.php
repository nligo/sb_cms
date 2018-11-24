<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $obj = new Article();
        $obj
            ->setTitle('article title')
            ->setDescription('article desc')
            ->setContents('article contents')
            ->setKeyword('article keyword')
            ->setIsShow(true)
            ->setPulicAt(new \DateTime());
        $manager->persist($obj);
        $manager->flush();
    }
}
