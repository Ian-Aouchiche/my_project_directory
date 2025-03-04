<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Material;
use App\Entity\Intervention;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création des utilisateurs
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setNom($faker->name)
                 ->setEmail($faker->email)
                 ->setMotDePasse(password_hash('password', PASSWORD_BCRYPT))
                 ->setRole('ouvrier');
            $manager->persist($user);
            $users[] = $user;
        }

        // Création des projets
        $projects = [];
        for ($i = 0; $i < 3; $i++) {
            $project = new Project();
            $project->setNom("Projet " . ($i + 1))
                    ->setDescription($faker->text)
                    ->setDateDebut($faker->dateTimeBetween('-1 year', 'now'))
                    ->setDateFin($faker->dateTimeBetween('now', '+6 months'))
                    ->setClient($faker->company)
                    ->setStatut("en cours");
            $manager->persist($project);
            $projects[] = $project;
        }

        // Création des matériaux
        for ($i = 0; $i < 10; $i++) {
            $material = new Material();
            $material->setNom("Matériau " . ($i + 1))
                     ->setType("Échafaudage")
                     ->setQuantite(rand(1, 20))
                     ->setEmplacement("Entrepôt " . rand(1, 3))
                     ->setProject($projects[array_rand($projects)]); // Associe à un projet au hasard
            $manager->persist($material);
        }

        // Création des interventions
        for ($i = 0; $i < 8; $i++) {
            $intervention = new Intervention();
            $intervention->setDate($faker->dateTimeBetween('-6 months', 'now'))
                         ->setDescription("Intervention sur site " . ($i + 1))
                         ->setEmploye($users[array_rand($users)]) // Associe à un employé au hasard
                         ->setProject($projects[array_rand($projects)]); // Associe à un projet au hasard
            $manager->persist($intervention);
        }

        $manager->flush();
    }
}
