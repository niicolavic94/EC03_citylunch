<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // --- CRÉATION DES UTILISATEURS ---

    
        $gerant = new User();
        $gerant->setYes('gerant@citylunch.fr'); // ton champ s'appelle 'yes'
        $gerant->setRoles(['ROLE_GERANT']);
        $gerant->setPassword($this->hasher->hashPassword($gerant, 'admin123'));
        $manager->persist($gerant);

       
        for ($i = 1; $i <= 2; $i++) {
            $livreur = new User();
            $livreur->setYes("livreur$i@citylunch.fr");
            $livreur->setRoles(['ROLE_LIVREUR']);
            $livreur->setPassword($this->hasher->hashPassword($livreur, 'livreur123'));
            $manager->persist($livreur);
        }



        $plats = [
            ['Blanquette de Veau', 12.50, 'Plat'],
            ['Lasagnes Maison', 10.90, 'Plat'],
            ['Salade César', 9.50, 'Plat'],
        ];

        $desserts = [
            ['Tiramisu', 4.50, 'Dessert'],
            ['Mousse au Chocolat', 4.00, 'Dessert'],
        ];

        foreach (array_merge($plats, $desserts) as $item) {
            $product = new Product();
            $product->setName($item[0]);
            $product->setPrice($item[1]);
            $product->setCategory($item[2]);
            $product->setDescription("Délicieux " . strtolower($item[0]) . " préparé ce matin.");
            $manager->persist($product);
        }

        $manager->flush();
    }
}