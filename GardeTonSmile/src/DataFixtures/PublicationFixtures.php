<?php

namespace App\DataFixtures;

use App\Entity\Publication;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PublicationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 5; $i++) {
            $p = new Publication();
            $p->setTitle('Publication '.$i);
            $p->setDescription('Description '.$i);
            $manager->persist($p); 
        }

        $manager->flush();
    }
}
