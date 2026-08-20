<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable {
 use HasFactory, Notifiable;
 protected $fillable=['name','email','phone','country_code','address','city','country','zip_code','password','role','avatar','is_verified','availability_status'];
 protected $hidden=['password','remember_token'];
 protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed','is_verified'=>'boolean']; }
 public function listings(){return $this->hasMany(Listing::class,'provider_id');}
 public function bookings(){return $this->hasMany(Booking::class,'customer_id');}
 public function providerBookings(){return $this->hasMany(Booking::class,'provider_id');}
 public function reviews(){return $this->hasMany(Review::class,'provider_id');}
 public function works(){return $this->hasMany(Work::class,'provider_id');}
 public function providerPayments(){return $this->hasMany(ProviderPayment::class);}
 public function supportMessages(){return $this->hasMany(SupportMessage::class);}
 public function isAdmin(){return $this->role==='admin';}
 public function isProvider(){return $this->role==='provider';}
}
