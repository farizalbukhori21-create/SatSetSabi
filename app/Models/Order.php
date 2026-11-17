<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id','denomination_id','order_code','player_id','server_id','customer_note',
        'amount','payment_method','payment_status','order_status','payment_proof','paid_at'
    ];
    protected function casts(): array { return ['amount' => 'integer', 'paid_at' => 'datetime']; }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function denomination(): BelongsTo { return $this->belongsTo(Denomination::class); }
}
