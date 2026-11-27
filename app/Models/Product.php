<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'product_name',
        'price',
        'stock',
        'description',
        'img_path',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'stock' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public static function searchProducts(
        int $login_user_id,
        ?string $product_name,
        ?int $min_price,
        ?int $max_price
    ) {
        return self::query()
            ->with('company')
            ->where('user_id', '!=', $login_user_id)
            ->when(
                filled($product_name),
                fn (Builder $query) => $query->where(
                    'product_name',
                    'like',
                    '%' . $product_name . '%'
                )
            )
            ->when(
                $min_price !== null,
                fn (Builder $query) => $query->where('price', '>=', $min_price)
            )
            ->when(
                $max_price !== null,
                fn (Builder $query) => $query->where('price', '<=', $max_price)
            )
            ->orderBy('id')
            ->get();
    }

    public static function getUserProducts(int $user_id)
    {
        return self::query()
            ->where('user_id', $user_id)
            ->orderBy('id')
            ->get();
    }
}
