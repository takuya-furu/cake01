<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Inertia\Inertia;
use Inertia\Response;

class MenuController extends Controller
{
    public function index(): Response
    {
        $menuItems = MenuItem::active()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category')
            ->map(fn ($items) => $items->map(fn ($item) => [
                'id'          => $item->id,
                'name'        => $item->name,
                'description' => $item->description,
                'price'       => $item->price,
                'image_url'   => $item->image_url,
            ]));

        return Inertia::render('Menu', [
            'menuItems' => $menuItems,
            'meta'      => [
                'title'       => 'イートインメニュー | UN GRAIN',
                'description' => 'UN GRAINのイートインメニュー。ケーキ・ドリンク・フードをご用意しています。',
            ],
        ]);
    }
}
