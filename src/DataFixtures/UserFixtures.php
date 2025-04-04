<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'email' => 'raphael@ferrovipath.com',
                'roles' => ['ROLE_USER'],
                'password' => '1234',
                'pseudo' => 'raphael',
                'birth' => new \DateTime('2004-06-20'),
            ],
            [
                'email' => 'amelia@ferrovipath.com',
                'roles' => ['ROLE_USER'],
                'password' => '1234',
                'pseudo' => 'amelia',
                'birth' => new \DateTime('2004-06-20'),
            ],
            [
                'email' => 'christine@ferrovipath.com',
                'roles' => ['ROLE_USER'],
                'password' => '1234',
                'pseudo' => 'christine',
                'birth' => new \DateTime('2004-06-20'),
            ],
            [
                'email' => 'steven@ferrovipath.com',
                'roles' => ['ROLE_USER'],
                'password' => '1234',
                'pseudo' => 'steven',
                'birth' => new \DateTime('2004-06-20'),
            ],
            [
                'email' => 'mod@ferrovipath.com',
                'roles' => ['ROLE_MODERATOR'],
                'password' => '1234',
                'pseudo' => 'moderator',
                'birth' => new \DateTime('1990-11-10'),
            ],
            [
                'email' => 'admin@ferrovipath.com',
                'roles' => ['ROLE_ADMIN'],
                'password' => '1234',
                'pseudo' => 'admin',
                'birth' => new \DateTime('1985-05-15'),
            ],
            [
                'email' => 'superadmin@ferrovipath.com',
                'roles' => ['ROLE_SUPER_ADMIN'],
                'password' => '1234',
                'pseudo' => 'superadmin',
                'birth' => new \DateTime('1980-01-01'),
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $user->setPseudo($userData['pseudo']);
            $user->setBirth($userData['birth']);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setUpdatedAt(new \DateTime());

            $hashedPassword = $this->passwordHasher->hashPassword($user, $userData['password']);
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
