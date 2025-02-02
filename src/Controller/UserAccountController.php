<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserAccount;
use App\Form\UserAccountCreateType;
use App\Service\UserAccountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccountController extends AbstractController
{
    private $userAccoutService;

    public function __construct(UserAccountService $userAccountService)
    {
        $this->userAccoutService = $userAccountService;
    }

    public function create(Request $request)
    {
        $deviceType = $request->attributes->get('device');

        $userAccount = new UserAccount;
        $form = $this->createForm(UserAccountCreateType::class, $userAccount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userAccoutService->registerUserAccount($userAccount, $this->getUser());

            return $this->redirectToRoute('user_mypage_show');
        }

        return $this->render("{$deviceType}/user_account/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    public function show(Request $request)
    {
        $deviceType = $request->attributes->get('device');

        $userAccout = $this->userAccoutService->searchUserAccount($this->getUser());

        if (empty($userAccout)) {
            return $this->redirectToRoute('user_mypage_create');
        };

        return $this->render("{$deviceType}/user_account/show.html.twig", [
            'userAccout' => $userAccout,
        ]);
    }
}
