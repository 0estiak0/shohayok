<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderMessage extends Model
{
    protected $fillable = ['provider_id', 'customer_id', 'sender_id', 'message', 'read_at'];
    protected $casts = ['read_at' => 'datetime'];
    public function provider() { return $this->belongsTo(User::class, 'provider_id'); }
    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }
}
