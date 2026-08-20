<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Work extends Model { protected $fillable=['provider_id','customer_name','title','description','location','images','rating','likes']; protected $casts=['images'=>'array','rating'=>'decimal:1']; public function provider(){return $this->belongsTo(User::class,'provider_id');} }
