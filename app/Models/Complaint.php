<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Complaint extends Model { protected $fillable=['user_id','booking_id','subject','description','status','assigned_to','admin_note']; public function user(){return $this->belongsTo(User::class);} public function booking(){return $this->belongsTo(Booking::class);} }
