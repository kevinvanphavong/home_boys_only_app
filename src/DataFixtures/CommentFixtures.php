<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use DateTime;


class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [EventFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 5; $i++) {
            $comment = new Comment;
            $comment->setContent($faker->text(200));
            $comment->setDate(new DateTime('now'));
            $comment->setEvent($this->getReference('event_1'));
            $comment->setAuthor($this->getReference('planner_1'));

            $manager->persist($comment);
            $this->addReference('comment_' . $i, $comment);
        }

        $manager->flush();
    }
}
