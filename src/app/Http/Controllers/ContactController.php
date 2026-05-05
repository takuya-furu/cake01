<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact', [
            'meta' => [
                'title'       => 'お問い合わせ | UN GRAIN',
                'description' => 'UN GRAINへのお問い合わせはこちらから。',
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'お名前を入力してください。',
            'email.required'   => 'メールアドレスを入力してください。',
            'email.email'      => '正しいメールアドレスを入力してください。',
            'message.required' => 'メッセージを入力してください。',
        ]);

        // TODO: メール送信 (Mail::to(...)->send(new ContactMail($validated)))

        return redirect()->route('contact.index')
            ->with('success', 'お問い合わせを受け付けました。3営業日以内にご返信いたします。');
    }
}
