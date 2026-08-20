<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;class DynamicForm extends Model{protected $fillable=['category_id','name','fields','is_active'];protected $casts=['fields'=>'array','is_active'=>'boolean'];}
