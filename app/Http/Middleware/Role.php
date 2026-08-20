<?php
namespace App\Http\Middleware;
use Closure;use Illuminate\Http\Request;
class Role {public function handle(Request $request,Closure $next,string $role){if(!$request->user()||$request->user()->role!==$role)abort(403);return $next($request);}}
