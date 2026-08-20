<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = ['user_id','sender_id','message','is_from_admin','read_at'];
    protected $casts = ['is_from_admin'=>'boolean','read_at'=>'datetime'];
    public function user(){ return $this->belongsTo(User::class); }
    public function sender(){ return $this->belongsTo(User::class,'sender_id'); }
}
