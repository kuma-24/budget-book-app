<?php

namespace App\Service;

class DashboardService
{
    public function getHeaderInfo(string $routeName)
    {
        $headerInfo = [
            'dashboard_home' => [
                'pageTitle' => '管理画面',
                'headerLinks' => [
                    [
                        'name' => 'マイページ',
                        'path' => 'user_mypage_show'
                    ],
                ],
            ],
        ];

        return $headerInfo[$routeName];
    }

    public function getFooterInfo(string $routeName)
    {
        $footerInfo = [
            'dashboard_home' => [
                'footerLinks' => [
                    [
                        'name' => 'HOME',
                        'path' => 'dashboard_home'
                    ],
                    [
                        'name' => 'サインアウト',
                        'path' => 'user_signout'
                    ],
                ],
            ],
        ];

        return $footerInfo[$routeName];
    }
}