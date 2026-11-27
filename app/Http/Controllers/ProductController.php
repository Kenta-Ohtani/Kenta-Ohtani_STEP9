<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search_data = $request->validate([
            'product_name' => ['nullable', 'string', 'max:255'],
            'min_price' => ['nullable', 'integer', 'min:0'],
            'max_price' => ['nullable', 'integer', 'min:0', 'gte:min_price'],
        ]);

        $product_name = $search_data['product_name'] ?? null;
        $min_price = isset($search_data['min_price'])
            ? (int) $search_data['min_price']
            : null;
        $max_price = isset($search_data['max_price'])
            ? (int) $search_data['max_price']
            : null;

        $product_list = Product::searchProducts(
            Auth::id(),
            $product_name,
            $min_price,
            $max_price
        );

        return view('product.index', compact(
            'product_list',
            'product_name',
            'min_price',
            'max_price'
        ));
    }

    public function show(Product $product): View
    {
        abort_if($product->user_id === Auth::id(), 403);

        $product->load('company');
        $is_liked = Like::existsForUser(Auth::id(), $product->id);

        return view('product.show', compact('product', 'is_liked'));
    }

    public function create(): View
    {
        return view('product.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $product_data = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string', 'max:255'],
            'img_path' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user = Auth::user();

        if ($user->company_id === null) {
            $company = Company::query()->firstOrCreate([
                'company_name' => '個人出品',
            ]);

            $user->update(['company_id' => $company->id]);
        }

        $product_data['user_id'] = $user->id;
        $product_data['company_id'] = $user->company_id;
        $product_data['img_path'] = $request
            ->file('img_path')
            ->store('products', 'public');

        Product::query()->create($product_data);

        return redirect()
            ->route('mypage.index')
            ->with('success', '商品を登録しました。');
    }

    public function sellingShow(Product $product): View
    {
        $this->authorizeOwner($product);

        return view('product.selling_show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $this->authorizeOwner($product);

        return view('product.edit', compact('product'));
    }

    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {
        $this->authorizeOwner($product);

        $product_data = $request->validate([
            'product_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string', 'max:255'],
            'img_path' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('img_path')) {
            Storage::disk('public')->delete($product->img_path);

            $product_data['img_path'] = $request
                ->file('img_path')
                ->store('products', 'public');
        }

        $product->update($product_data);

        return redirect()
            ->route('product.selling.show', $product)
            ->with('success', '商品情報を更新しました。');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorizeOwner($product);

        Storage::disk('public')->delete($product->img_path);
        $product->delete();

        return redirect()
            ->route('mypage.index')
            ->with('success', '商品を削除しました。');
    }

    private function authorizeOwner(Product $product): void
    {
        abort_unless($product->user_id === Auth::id(), 403);
    }
}
