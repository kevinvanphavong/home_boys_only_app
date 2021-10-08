<?php

namespace App\DataFixtures;

use App\Entity\GatheringComplement;
use App\Entity\GatheringComplementIncluded;
use App\Entity\GatheringComplementToBring;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GatheringComplementsFixtures extends Fixture
{
    private $complements = [
        'music'             => 'music_note',
        'food'              => 'restaurant',
        'drink'             => 'local_drink',
        'decoration'        => 'local_florist',
        'good-vibes'        => 'thumb_up_alt',
        'humour'            => 'mood',
        'games'             => 'games',
        'photographer'      => 'camera_enhance',
        'dj'                => 'headphones',
        'cleaning'          => 'cleaning_services',
        'sleeping-bag'      => 'hotel'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->complements as $key => $value) {
            $complement = new GatheringComplementIncluded();
            $complement->setName(ucfirst($key));
            $complement->setIcon($value);
            $manager->persist($complement);
        }

        foreach ($this->complements as $key => $value) {
            $complement = new GatheringComplementToBring();
            $complement->setName(ucfirst($key));
            $complement->setIcon($value);
            $manager->persist($complement);
        }

        $manager->flush();
    }
}
