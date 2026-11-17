<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Denomination extends Model
{
    protected $fillable = ['product_id','name','price','is_active'];
    protected function casts(): array { return ['price' => 'integer', 'is_active' => 'boolean']; }
    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
    public function orders(): HasMany { return $this->hasMany(Order::class); }
}
