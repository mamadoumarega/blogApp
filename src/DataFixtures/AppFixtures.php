<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'johndoe@gmail.com']);

        foreach (range(1, 10) as $ignored) {
            $category = new Category();
            $category
                ->setName($faker->sentence)
                ->setDescription($faker->paragraph)
                ->setSlug($faker->slug)
            ;

            $manager->persist($category);

            $article = new Article();
            $article
                ->setSlug($faker->slug)
                ->setName($faker->sentence)
                ->setCategory($category)
                ->setLabel($faker->sentence)
                ->setDescription($faker->paragraph)
                ->setDateCreated($faker->dateTime)
                ->setIsPublished(true)
                ->setImage($faker->image)
                ->setViews(0)
                ->setAuthor($user)
            ;

            $manager->persist($article);

            $comment = new Comment();
            $comment
                ->setContent($faker->paragraph)
                ->setArticle($article)
                ->setAuthor($user)
                ->setCreatedAt($faker->dateTime)
            ;

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
