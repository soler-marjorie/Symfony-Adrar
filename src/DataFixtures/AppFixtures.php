<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Account;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    // public function load(ObjectManager $manager): void
    // {
    //     // $product = new Product();
    //     // $manager->persist($product);

    //     $manager->flush();
    // }


    /*
    Exercice 1 Fixtures et Faker :
        Créer dans la classe DataFixtures :
        50 utilisateurs (Account),
        100 articles (Articles),
        rattacher un Account aléatoire à chaque Article.
        En utilisant la librairie Faker (chercher les méthodes qui peuvent correspondre).
    */
    public function load(ObjectManager $manager): void{

        $faker = Faker\Factory::create('fr_FR');

        $accounts = [];
        $categories = [];

        for ($i=0; $i < 50 ; $i++) { 
            //Ajouter un compte
            $account = new Account();
            $account->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName())
                    ->setEmail($faker->unique()->email())
                    ->setPassword($faker->password())
                    ->setRoles("ROLE_USER");
            //Ajout en cache
            $manager->persist($account);
            $accounts[] = $account;
        }

        for ($j = 0; $j < 100 ; $j++) {
            $articles = new Article();
            $articles->setTitle($faker->sentence(3))
                    ->setContent($faker->text(200))
                    ->setCreateAt($faker->dateTimeThisYear())
                    ->setAuthor($accounts[$faker->numberBetween(0, 49)]);
            //Ajout des catégories
            $articles->addCategory($categories[$faker->numberBetween(0, 9)]);
            $articles->addCategory($categories[$faker->numberBetween(10, 19)]);
            $articles->addCategory($categories[$faker->numberBetween(20, 29)]);
            $manager->persist($articles);
        }

        for ($k = 0; $k < 30 ; $k++) { 
            $category = new Category();
            $category->setName($faker->firstName());
            $manager->persist($account);
            $categories[] = $category;
        }

        //Enregistrement en base de données     
        $manager->flush();
    }


    /*
    //Exemple de création de compte (Account) :
    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < 20 ; $i++) { 
            //Ajouter un compte
            $account = new Account();
            $account->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName())
                    ->setEmail($faker->email())
                    ->setPassword($faker->password())
                    ->setRoles("ROLE_USER");
            //Ajout en cache
            $manager->persist($account);
        }
        
        //Enregistrement en base de données     
        $manager->flush();
    }
    */


}

