<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    public function top(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');

        return $this->render("{$deviceType}/dashboard/top.html.twig");
    }

    public function home(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');

        return $this->render("{$deviceType}/dashboard/home.html.twig");
    }
}
