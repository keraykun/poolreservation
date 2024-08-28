@extends('home.layout')
@section('content')
<main>

    @if (Auth::check())
    <section class="p-5 rounded-sm flex flex-col flex-wrap items-start justify-start w-full gap-5 ">
        <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto lg:py-0 mt-5 text-3xl font-bold" >
           Message
        </div>
        <div class=" flex flex-col items-start justify-start  py-10 my-2 mx-auto  min-w-[50%] lg:py-0 mt-5"  style="border:1px solid #b0b0b0;   ">

        <div class="w-full" style=" box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
        -webkit-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="uppercase font-bold text-lg">
                        <th scope="col" class="px-6 py-3">
                            Staff Account
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Subject
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Message
                        </th>
                        {{-- <th scope="col" class="px-6 py-3">
                            Status
                        </th> --}}
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->messagetitle as $message)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-lg">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $message->user->name }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $message->name }}
                        </th>
                        <th scope="col" class="px-6 py-3 my-2 flex items-center flex-row justify-center gap-2 text-green-500">
                            <i class="fa-solid fa-message"></i> <span>{{ $message->message_count }}</span>
                        </th>
                        {{-- <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if ($message->active)
                                <span class="text-green-500">Active</span>
                            @else
                            <span class="text-lime-500">Done</span>
                            @endif
                        </th> --}}
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ date('M d ,Y h:i a',strtotime($message->created_at)) }}
                        </th>
                        <th scope="row" class="cursor-pointer underline text-sky-600 px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           <a href="{{ route('home.message.inbox',$message->id) }}">Show</a>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        </div>

    </section>

    @else
    <section class="p-5 rounded-sm flex flex-row flex-wrap items-start justify-start w-full gap-5 bg-[length:800px_800px] bg-blue-200 bg-no-repeat bg-center bg-[url('/public/images/logo_bg.png')] ">
        <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto sm:h-screen lg:py-0 mt-5">
            <div class="w-full  rounded-lg  dark:border md:mt-0  xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <p class="text-3xl drop-shadow-sm text-slate-600">You need to login first to see your schedule. Click to <a href="{{ route('guest.index') }}" class="text-sky-700 font-bold">Login</a></p>
            </div>
        </div>
    </section>
    @endif


</main>

@endsection
