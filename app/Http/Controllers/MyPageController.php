<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MyPageController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $product_list = Product::getUserProducts($user->id);
        $sale_list = Sale::getUserSales($user->id);

        return view('mypage.index', compact(
            'user',
            'product_list',
            'sale_list'
        ));
    }
}
