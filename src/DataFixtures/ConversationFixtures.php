<?php

namespace App\DataFixtures;

use App\Entity\Conversation;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ConversationFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [EventFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 10; $i++) { 
            $conversation = new Conversation();

            $conversation->setUserPlanner($this->getReference('planner_1'));
            $conversation->setUserGuest($this->getReference('planner_' . ($i + 1)));
            $conversation->setParty($this->getReference('event_' . $i));

            $manager->persist($conversation);
            $this->addReference('conversation_' . $i, $conversation);
        }

        for ($i=1; $i <= 3; $i++) {
            $conversation = new Conversation();

            $conversation->setUserPlanner($this->getReference('planner_' . ($i + 1)));
            $conversation->setUserGuest($this->getReference('planner_1'));
            $conversation->setParty($this->getReference('event_' . ($i + 20)));

            $manager->persist($conversation);
            $this->addReference('conversation_' . ($i + 10), $conversation);
        }

        $manager->flush();
    }
}
