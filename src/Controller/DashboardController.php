<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    public function home(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');

        return $this->render("{$deviceType}/dashboard/home.html.twig");
    }
}
