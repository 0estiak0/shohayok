<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;class MapMarker extends Model{protected $fillable=['title','type','latitude','longitude','icon','meta','is_active'];protected $casts=['meta'=>'array','is_active'=>'boolean'];}
