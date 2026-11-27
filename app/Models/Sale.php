<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function buyProduct(
        int $user_id,
        int $product_id,
        int $quantity
    ): self {
        return DB::transaction(function () use ($user_id, $product_id, $quantity): self {
            $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($product_id);

            if ($product->user_id === $user_id) {
                throw new RuntimeException('自分で出品した商品は購入できません。');
            }

            if ($quantity < 1) {
                throw new RuntimeException('購入個数は1以上で入力してください。');
            }

            if ($quantity > $product->stock) {
                throw new RuntimeException('在庫数を超える個数は購入できません。');
            }

            $sale = self::query()->create([
                'user_id' => $user_id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            $product->decrement('stock', $quantity);

            return $sale;
        });
    }

    public static function getUserSales(int $user_id)
    {
        return self::query()
            ->with('product')
            ->where('user_id', $user_id)
            ->orderBy('product_id')
            ->get();
    }
}
