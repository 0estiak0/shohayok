<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Listing extends Model
{
    protected $fillable=['provider_id','category_id','type','title','slug','description','price','discount_price','price_unit','latitude','longitude','address','city','country','images','attributes','status','is_featured','is_sponsored','views','available'];
    protected $casts=['images'=>'array','attributes'=>'array','is_featured'=>'boolean','is_sponsored'=>'boolean','available'=>'boolean','price'=>'decimal:2','discount_price'=>'decimal:2'];
    public function provider(){return $this->belongsTo(User::class,'provider_id');}
    public function category(){return $this->belongsTo(Category::class);}
    public function bookings(){return $this->hasMany(Booking::class);}
}
