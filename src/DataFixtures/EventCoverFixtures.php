<?php

namespace App\DataFixtures;

use App\Entity\EventCover;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventCoverFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [EventFixtures::class];
    }
    
    private $cover = 'hbo-background-header-homepage.jpg';

    public function load(ObjectManager $manager): void
    {
        for ($i=21; $i < 26; $i++) { 
            $cover = new EventCover;
            $cover->setName($this->cover);
            $cover->setEvent($this->getReference('event_' . $i));

            $manager->persist($cover);
        }

        $manager->flush();
    }
}
