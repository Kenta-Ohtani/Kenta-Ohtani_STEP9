<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(): View
    {
        $user = Auth::user();

        return view('account.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $user_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'name_kanji' => ['required', 'string', 'max:255'],
            'name_kana' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[ァ-ヶー\s]*$/u',
            ],
        ]);

        $user->update($user_data);

        return redirect()
            ->route('mypage.index')
            ->with('success', 'アカウント情報を更新しました。');
    }
}
