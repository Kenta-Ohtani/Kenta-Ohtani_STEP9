<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function toggleLike(int $user_id, int $product_id): bool
    {
        $like = self::query()
            ->where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if ($like !== null) {
            $like->delete();

            return false;
        }

        self::query()->create([
            'user_id' => $user_id,
            'product_id' => $product_id,
        ]);

        return true;
    }

    public static function existsForUser(int $user_id, int $product_id): bool
    {
        return self::query()
            ->where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->exists();
    }
}
