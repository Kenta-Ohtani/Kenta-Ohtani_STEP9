<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Product $product): JsonResponse
    {
        abort_if($product->user_id === Auth::id(), 403);

        $is_liked = Like::toggleLike(Auth::id(), $product->id);

        return response()->json([
            'is_liked' => $is_liked,
        ]);
    }
}
