<?php

namespace App\DataFixtures;

use App\Entity\Notification;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NotificationFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [EventFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        for ($j=0; $j < 5; $j++) { 
            for ($i=1; $i < 11; $i++) {    
                
                $notification = new Notification();
                $notification->setAuthor($this->getReference('planner_1'));
                $notification->setRecipient($this->getReference('planner_' . $i));
                $notification->setEvent($this->getReference('event_21'));
                $notification->setCreatedAt(date_modify(new DateTime(), '+' . $i . ' minute'));
    
                $manager->persist($notification);
                
            }  
        }
            $manager->flush();
    }
}
