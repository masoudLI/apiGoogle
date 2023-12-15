<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminCommand
{

    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $em
    )
    {
    }


    public function create (string $email, string $password): bool
    {
        $user = $this->userRepository->findBy(['email' => $email]);
        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setPseudo(substr($user->getEmail(), 0, strpos($user->getEmail(), "@")));
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));
        }
        $user->setRoles(['ROLE_ADMIN']);
        $this->em->persist($user);
        $this->em->flush();
        return true;
    }

}
