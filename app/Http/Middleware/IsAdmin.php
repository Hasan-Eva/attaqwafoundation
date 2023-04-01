<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      if(Auth::check()){
		if(auth()->user()->is_admin == 1){
		 return $next($request);
		 } else{
		  return redirect()->route('admin.home');
		 }
	  } else {
		return redirect()->route('home')->with('error','You don have admin access');
	  }
    }
}
