<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserSigninType;
use App\Form\UserSignupType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function signin(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $deviceType = $request->attributes->get('device');

        $user = new User;
        $form = $this->createForm(UserSigninType::class, $user);

        return $this->render("{$deviceType}/user/signin.html.twig", [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'form' => $form->createView(),
        ]);
    }

    public function signup(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');

        $user = new User;
        $form = $this->createForm(UserSignupType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->userService->registerUser($user);

            return $this->redirectToRoute('user_signin');
        }

        return $this->render("{$deviceType}/user/signup.html.twig", [
            'form' => $form->createView(),
        ]);
    }
}
