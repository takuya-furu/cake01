<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::with('category')->published();

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) =>
                $q->where('slug', $request->category)
            );
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug']);

        return Inertia::render('Products/Index', [
            'products'   => $products,
            'categories' => $categories,
            'filters'    => $request->only('category'),
            'meta'       => [
                'title'       => '商品一覧 | UN GRAIN',
                'description' => 'UN GRAINのこだわりケーキ一覧。季節限定商品も多数ご用意しています。',
            ],
        ]);
    }

    public function show(Product $product): Response
    {
        abort_unless(
            (! $product->published_at || $product->published_at <= now()) &&
            (! $product->unpublished_at || $product->unpublished_at > now()),
            404
        );

        $product->load('category');

        $related = Product::with('category')
            ->published()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get()
            ->map(fn ($p) => [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => $p->price,
                'image_url' => $p->image_url,
                'category'  => $p->category?->name,
            ]);

        return Inertia::render('Products/Show', [
            'product' => [
                'id'          => $product->id,
                'name'        => $product->name,
                'description' => $product->description,
                'price'       => $product->price,
                'image_url'   => $product->image_url,
                'is_seasonal' => $product->is_seasonal,
                'category'    => $product->category?->name,
            ],
            'related' => $related,
            'meta'    => [
                'title'       => $product->name . ' | UN GRAIN',
                'description' => $product->description
                    ? mb_strimwidth($product->description, 0, 120, '…')
                    : $product->name . 'の詳細ページです。',
            ],
        ]);
    }
}
