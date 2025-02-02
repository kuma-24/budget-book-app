<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserAccount;
use App\Repository\UserAccountRepository;

class UserAccountService
{
    private $userAccountRepository;

    public function __construct(UserAccountRepository $userAccountRepository)
    {
        $this->userAccountRepository = $userAccountRepository;
    }

    public function registerUserAccount(UserAccount $userAccount, User $user)
    {
        $userAccount->setUser($user);

        $this->userAccountRepository->save($userAccount);
    }

    public function searchUserAccount(User $user)
    {
        return $this->userAccountRepository->findByUserAccount($user->getId());
    }
}