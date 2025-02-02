<?php

namespace App\Controller;

use App\Service\DashboardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function top(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');

        return $this->render("{$deviceType}/dashboard/top.html.twig");
    }

    public function home(Request $request): Response
    {
        $deviceType = $request->attributes->get('device');
        $routeName = $request->attributes->get('routeName');
        $headerInfo = $this->dashboardService->getHeaderInfo($routeName);
        $footerInfo = $this->dashboardService->getFooterInfo($routeName);

        return $this->render("{$deviceType}/dashboard/home.html.twig", [
            'pageTitle' => $headerInfo['pageTitle'],
            'headerLinks' => $headerInfo['headerLinks'],
            'footerLinks' => $footerInfo['footerLinks'],
        ]);
    }
}
