<?php

namespace App\Http\Middleware;

use App\Models\Bookings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;
class ExpirationHour
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bookings = Bookings::where('payment','pending')->get();
        $toDay = Carbon::now('Asia/Manila');
        foreach ($bookings as $booking) {
            if ($toDay->gt($booking->expire)) {
            Bookings::where('barcode',$booking->barcode)
            ->where('payment','pending')
            ->update(['payment'=>'Expired']);
            }
        }
        // if ($toDay->gt($booking->expire)) {
        //     $expiration = 'Expired';
        //     Bookings::where('barcode',$booking->barcode)
        //     ->where('payment','pending')
        //     ->update(['payment'=>'Expired']);
        // } else {
        //     $expiration = $toDay->diffForHumans($booking->expire).' Expiration ';
        // }

        return $next($request);
    }
}
