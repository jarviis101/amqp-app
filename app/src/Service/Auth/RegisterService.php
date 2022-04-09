<?php

namespace App\Service\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    private UserPasswordHasherInterface $hasher;
    private EntityManagerInterface $em;

    public function __construct(UserPasswordHasherInterface $hasher, EntityManagerInterface $em)
    {
        $this->hasher = $hasher;
        $this->em = $em;
    }

    /**
     * @throws Exception
     */
    public function register(RegisterDTO $authDTO): void
    {
        $user = new User($authDTO);
        $hashedPassword = $this->hasher->hashPassword(
            $user,
            $authDTO->password
        );
        $user->setPassword($hashedPassword);
        $user->setApiToken(bin2hex(random_bytes(8)));

        $this->em->persist($user);
        $this->em->flush();
    }
}
