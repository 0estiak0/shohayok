<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model { protected $fillable=['key','value','group']; public static function get($key,$default=null){$v=static::where('key',$key)->value('value'); return $v===null?$default:$v;} }
