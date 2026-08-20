<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Category extends Model { protected $fillable=['name','slug','type','icon','description','is_active','sort_order','form_schema']; protected $casts=['is_active'=>'boolean','form_schema'=>'array']; public function listings(){return $this->hasMany(Listing::class);} }
