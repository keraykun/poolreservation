@extends('home.layout')
@section('content')
<main>
    <section  style="min-height:600px;"  class="p-5 rounded-sm flex flex-row flex-wrap items-center justify-center w-full ">
        <div class="w-full flex flex-col items-center justify-center px-6 py-8 mx-auto  lg:py-0">
            <div class="w-full flex items-center justify-center bg-white dark:border md:mt-0  xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6  flex items-center justify-center space-y-4 md:space-y-6 sm:p-8 w-full ">
                    <img class="object-fill rounded-lg shadow"  style=" border:5px solid black;" src="{{ asset('images/map.png') }}" alt="">
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
