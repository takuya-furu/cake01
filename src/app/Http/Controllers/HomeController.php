<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $pickups = Product::with('category')
            ->published()
            ->where('is_pickup', true)
            ->latest()
            ->take(6)
            ->get()
            ->map(fn ($p) => [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => $p->price,
                'image_url' => $p->image_url,
                'category'  => $p->category?->name,
            ]);

        $latestPosts = Post::published()
            ->latest('published_at')
            ->take(3)
            ->get(['id', 'title', 'published_at']);

        return Inertia::render('Home', [
            'pickups'     => $pickups,
            'latestPosts' => $latestPosts,
            'meta'        => [
                'title'       => 'UN GRAIN - 駅近のケーキ屋・イートインカフェ',
                'description' => 'こだわりのケーキとイートインスペースで、ゆったりとした時間を。駅徒歩2分。',
            ],
        ]);
    }
}
