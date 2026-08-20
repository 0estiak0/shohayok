<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Review extends Model { protected $fillable=['listing_id','customer_id','provider_id','rating','comment']; public function customer(){return $this->belongsTo(User::class,'customer_id');} public function listing(){return $this->belongsTo(Listing::class);} }
