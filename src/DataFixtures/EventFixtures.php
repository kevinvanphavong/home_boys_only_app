<?php

namespace App\DataFixtures;

use App\Entity\Event;
use DateInterval;
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

        for ($i = 1; $i <= 20; $i++) {
            $event = new Event;
            $event->setTitle($faker->word(10));
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
