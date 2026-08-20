<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Booking extends Model { protected $fillable=['listing_id','customer_id','provider_id','start_at','end_at','amount','status','notes','address']; protected $casts=['start_at'=>'datetime','end_at'=>'datetime','amount'=>'decimal:2']; public function listing(){return $this->belongsTo(Listing::class);} public function customer(){return $this->belongsTo(User::class,'customer_id');} public function provider(){return $this->belongsTo(User::class,'provider_id');} }
