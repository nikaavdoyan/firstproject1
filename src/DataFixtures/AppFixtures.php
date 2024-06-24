<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipeet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;
use Symfony\Flex\Recipe;

class AppFixtures extends Fixture
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    
    public function load(ObjectManager $manager): void
    {
        //data ingredient
        $ingredient =[];
        for ($i=0; $i < 50; $i++){
        $ingredient = new Ingredient();
        //le nom prendra la chaine de caractère 'ingredient' avec la valeur de $i
        $ingredient->setName($this->faker->word())
        //on fait un random entre 0 et 100 pour le prix 
                   ->setPrice(mt_rand(0,100));
        //ajout de l'ingredient dans le tableau
        $ingredients[] =$ingredient;
        
        $manager->persist($ingredient);
        }
        //data Recipes
        for ($j=0; $j <25 ; $j++){
            $recipe = new Recipeet();
            $recipe ->setName($this->faker->word())
            ->setTime(mt_rand(1, 1440))
            ->setNbpeople(mt_rand(0,1)==1? mt_rand(1,50):null)
            ->setDifficulty(mt_rand(0,1)==1? mt_rand(1,5):null)
            ->setDescription($this->faker->text(300))
            ->setPrice(mt_rand(0,1)==1? mt_rand(1,1000):null)
            ->setIsfavorite(mt_rand(0,1)==1? true:false);

            for($k=0; $k <mt_rand(5,15) ; $k++){
                $recipe->addIngredient($ingredients[mt_rand(0,count($ingredients)-1)]);
            }
            $manager->persist($recipe);
        }


        $manager->flush();
    }
}