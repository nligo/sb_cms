<?php

namespace App\DataFixtures;

use App\Entity\WebSetting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class WebSettingFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $webSetting = new WebSetting();
        $webSetting
            ->setName('SB CMS')
            ->setEmail('admin@admin.com')
            ->setPhone('13000000000')
            ->setContact('admin')
            ->setDescription('')
            ->setIcp('')
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());
        $manager->persist($webSetting);
        $manager->flush();
    }
}
