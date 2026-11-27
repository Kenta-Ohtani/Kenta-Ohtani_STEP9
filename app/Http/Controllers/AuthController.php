<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $login_data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($login_data, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'メールアドレスまたはパスワードが正しくありません。',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('product.index'));
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $user_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_kanji' => ['required', 'string', 'max:255'],
            'name_kana' => ['nullable', 'string', 'max:255', 'regex:/^[ァ-ヶー\s]*$/u'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $default_company = Company::query()->firstOrCreate([
            'company_name' => '個人出品',
        ]);

        $user_data['company_id'] = $default_company->id;
        $user_data['password'] = Hash::make($user_data['password']);

        User::query()->create($user_data);

        return redirect()
            ->route('login')
            ->with('success', '新規ユーザー登録が完了しました。');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
