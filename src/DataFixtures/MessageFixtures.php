<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Message;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [ConversationFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for ($i=1; $i <= 10; $i++) { 
            $message = new Message();

            if($i <= 5) {
                $message->setAuthor($this->getReference('planner_1'));
                $message->setRecipient($this->getReference('planner_2'));
            } else {
                $message->setAuthor($this->getReference('planner_2'));
                $message->setRecipient($this->getReference('planner_1'));
            }
            $message->setCreatedAt(date_modify(new DateTime(), '+'. $i . ' minute'));
            $message->setSendAt(date_modify(new DateTime(), '+' . $i . ' minute'));

            if ($i < 7) {
                $message->setConversation($this->getReference('conversation_11'));
            } else {
                $message->setConversation($this->getReference('conversation_1'));
            }
            
            $message->setContent($faker->text(100));

            $manager->persist($message);
        }

        $manager->flush();
    }
}
