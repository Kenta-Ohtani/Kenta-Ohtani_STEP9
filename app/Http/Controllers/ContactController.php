<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact.index');
    }

    public function send(Request $request): RedirectResponse
    {
        $contact_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'contact_content' => ['required', 'string', 'max:5000'],
        ]);

        $admin_email = config('marketplace.contact_admin_email');

        if (filled($admin_email)) {
            try {
                Mail::raw(
                    "名前：{$contact_data['name']}\n"
                    . "メールアドレス：{$contact_data['email']}\n\n"
                    . $contact_data['contact_content'],
                    function ($message) use ($admin_email, $contact_data): void {
                        $message
                            ->to($admin_email)
                            ->replyTo($contact_data['email'], $contact_data['name'])
                            ->subject('MyShop お問い合わせ');
                    }
                );
            } catch (Throwable $exception) {
                Log::error('お問い合わせメールの送信に失敗しました。', [
                    'exception' => $exception->getMessage(),
                    'contact' => $contact_data,
                ]);
            }
        } else {
            Log::info('お問い合わせ内容', $contact_data);
        }

        return redirect()
            ->route('product.index')
            ->with('success', 'お問い合わせを送信しました。');
    }
}
