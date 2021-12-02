<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use Faker;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $event = new Event;
        $event->setTitle('Hip Hop Winter Break 2021');
        $event->setStartingDate(new DateTime('2020-10-17 20:00:00'));
        $event->setEndingDate(new DateTime('2020-10-18 04:00:00'));
        $event->setEndOfRegistrations(new DateTime('2020-10-17 18:00:00'));
        $event->setPlanner($this->getReference('planner_1'));
        $event->setCountry('France');
        $event->setCity('Lyon');
        $event->setAddress('47 rue du professeur patel');
        $event->setPresentation($faker->text(400));
        $event->setLimitedPlaces(20);
        $event->setEntrancePrice(10);

        for ($index = 21; $index < 26; $index++) { 
            $event = new Event;
            $event->setTitle('Hip Hop Winter Break 2021');
            $event->setStartingDate(new DateTime('2020-10-17 20:00:00'));
            $event->setEndingDate(new DateTime('2020-10-18 04:00:00'));
            $event->setEndOfRegistrations(new DateTime('2020-10-17 18:00:00'));
            $event->setPlanner($this->getReference('planner_1'));
            $event->setCountry('France');
            $event->setCity('Lyon');
            $event->setAddress('47 rue du professeur patel');
            $event->setPresentation($faker->text(400));
            $event->setLimitedPlaces(20);
            $event->setEntrancePrice(10);

            // gérer event pictures
            
            // gérer event cover
            
            $event->addGatheringComplementsIncluded(
                $this->getReference('complement_included_food')
            );
            $event->addGatheringComplementsIncluded(
                $this->getReference('complement_included_drink')
            );
            $event->addGatheringComplementsIncluded(
                $this->getReference('complement_included_music')
            );

            $event->addGatheringComplementsToBring(
                $this->getReference('complement_to_bring_decoration')
            );
            $event->addGatheringComplementsToBring(
                $this->getReference('complement_to_bring_good-vibes')
            );
            $event->addGatheringComplementsToBring(
                $this->getReference('complement_to_bring_humour')
            );

            $manager->persist($event);
            $this->addReference('event_' . $index, $event);
        }

        for ($i = 1; $i <= 20; $i++) {
            $event = new Event;
            $event->setTitle(ucfirst($faker->word(10)));
            $event->setStartingDate(new DateTime('2020-10-17 20:00:00'));
            $event->setEndingDate(new DateTime('2020-10-18 04:00:00'));
            $event->setPlanner($this->getReference('planner_1'));
            if ($i % 2 === 0) {
                $event->setEntrancePrice(0);
                // $event->setAccomodation('Duplex');
                $event->setCountry('Espagne');
                $event->setCity('Alicante');
                $event->setAddress('69 calle de la Mujer');
                $event->setLimitedPlaces(20);
            } else {
                $event->setCountry('Espagne');
                $event->setEntrancePrice(10);
                // $event->setAccomodation('Villa');
                $event->setCity('Barcelona');
                $event->setAddress('45 calle de Mortadel');
                $event->setLimitedPlaces(30);
            }
            $event->setPresentation($faker->text(200));
            $event->setEndOfRegistrations(new DateTime('2020-10-17 18:00:00'));

            $manager->persist($event);
            $this->addReference('event_' . $i, $event);
        }

        $manager->flush();
    }
}
