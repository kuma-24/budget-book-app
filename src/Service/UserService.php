<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    private $passwordHasher;
    private $userRepository;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
    }

    public function registerUser(User $user)
    {
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        
        $this->userRepository->save($user);
    }
}