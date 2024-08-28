@extends('home.layout')
@section('content')
<main>
    @if (Auth::check())
    <div class="max-w-7xl mx-auto p-20 border w-[600px]" style="border-radius:30px; box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
    -webkit-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
    -moz-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);">
       <div class="flex flex-col items-center justify-center gap-8 text-slate-700 font-medium">
        <i class="fas fa-calendar text-8xl "></i>
        <span class="text-3xl italic">Looks like you don't have any reservations yet, <a  href="{{ route('home.bookings.index') }}" class="text-blue-400">Click here</a> to book now.</span>
       </div>
    </div>
    @else
    <section class="p-5 rounded-sm flex flex-row flex-wrap items-start justify-start w-full gap-5">
        <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto sm:h-screen lg:py-0 mt-5">
            <div class="w-full  rounded-lg  dark:border md:mt-0  xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <p class="text-3xl drop-shadow-sm text-slate-600">You need to login first to see your schedule. Click to <a href="{{ route('guest.index') }}" class="text-sky-700 font-bold">Login</a></p>
            </div>
        </div>
    </section>
    @endif


</main>

@endsection
