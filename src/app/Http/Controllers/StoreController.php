<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class StoreController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Store', [
            'meta' => [
                'title'       => '店舗情報 | UN GRAIN',
                'description' => 'UN GRAINの店舗情報。アクセス・営業時間・席数のご案内。',
                'jsonLd'      => [
                    '@context'       => 'https://schema.org',
                    '@type'          => 'Bakery',
                    'name'           => 'UN GRAIN',
                    'address'        => [
                        '@type'           => 'PostalAddress',
                        'addressLocality' => '東京都',
                    ],
                    'openingHours'   => 'Tu-Su 11:00-19:00',
                    'hasMenu'        => url('/menu'),
                ],
            ],
        ]);
    }
}
