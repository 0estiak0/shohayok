<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderPayment extends Model
{
    protected $fillable = [
        'user_id','regular_price','discount_percent','discount_amount','total_amount',
        'payment_method','sender_number','transaction_id','status','admin_note','approved_at'
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    public function user(){ return $this->belongsTo(User::class); }
}
