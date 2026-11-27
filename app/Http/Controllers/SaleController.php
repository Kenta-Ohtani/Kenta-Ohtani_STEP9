<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;

class SaleController extends Controller
{
    public function create(Product $product): View
    {
        abort_if($product->user_id === Auth::id(), 403);

        $product->load('company');

        return view('sale.create', compact('product'));
    }

    public function store(
        Request $request,
        Product $product
    ): RedirectResponse {
        $sale_data = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:' . $product->stock,
            ],
        ]);

        try {
            Sale::buyProduct(
                Auth::id(),
                $product->id,
                (int) $sale_data['quantity']
            );
        } catch (RuntimeException $exception) {
            throw ValidationException::withMessages([
                'quantity' => $exception->getMessage(),
            ]);
        }

        return redirect()
            ->route('product.index')
            ->with('success', '商品の購入が完了しました。');
    }
}
