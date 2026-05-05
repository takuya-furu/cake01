<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(): Response
    {
        $posts = Post::published()
            ->latest('published_at')
            ->paginate(10);

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'meta'  => [
                'title'       => 'お知らせ | UN GRAIN',
                'description' => 'UN GRAINからの最新のお知らせ・イベント情報をお届けします。',
            ],
        ]);
    }

    public function show(Post $post): Response
    {
        abort_unless(
            (! $post->published_at || $post->published_at <= now()) &&
            (! $post->unpublished_at || $post->unpublished_at > now()),
            404
        );

        $description = mb_strimwidth(strip_tags($post->body), 0, 120, '…');

        return Inertia::render('Posts/Show', [
            'post' => $post,
            'meta' => [
                'title'       => $post->title . ' | UN GRAIN',
                'description' => $description,
                'jsonLd'      => [
                    '@context'      => 'https://schema.org',
                    '@type'         => 'Article',
                    'headline'      => $post->title,
                    'datePublished' => $post->published_at?->toIso8601String(),
                    'dateModified'  => $post->updated_at->toIso8601String(),
                    'publisher'     => [
                        '@type' => 'Organization',
                        'name'  => 'UN GRAIN',
                    ],
                ],
            ],
        ]);
    }
}
