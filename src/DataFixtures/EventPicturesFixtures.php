<?php

namespace App\DataFixtures;

use App\Entity\EventPicture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventPicturesFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [EventFixtures::class];
    }

    private $images = [
        'enter.jpg',
        'girls-have-fun.jpg',
        'homeboys-bgc.jpg',
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i=21; $i < 26; $i++) {      
            foreach ($this->images as $key => $value) {
                $picture = new EventPicture;
                $picture->setName($value);
                $picture->setEvent($this->getReference('event_' . $i));
                
                $manager->persist($picture);
            }
        }

        $manager->flush();
    }
}
