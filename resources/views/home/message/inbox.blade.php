@extends('home.layout')
@section('content')
<main>

    @if (Auth::check())
    <section class="p-5 rounded-sm flex flex-col flex-wrap items-start justify-start w-full gap-5 ">
        <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto lg:py-0 mt-5 text-3xl font-bold" >
           Message
        </div>

        <div class=" flex flex-col items-start justify-start  my-2 mx-auto border  min-w-[50%] lg:py-0 mt-5" style=" box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
                -webkit-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
                -moz-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75); padding:10px;">
                <div class="my-3">
                    <a href="{{ route('home.message.show',$user->id) }}" class="py-2 px-3  text-white rounded-md shadow-md bg-slate-400 w-full">Back</a>
                </div>
                <div class="flex items-start gap-2.5 w-full">
                    <div class="text-md flex flex-col w-full  leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-400">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</span>
                        <span class="font-normal text-gray-500 dark:text-gray-400">{{ date('M d ,Y h:i a',strtotime($user->created_at)) }}</span>
                    </div>
                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                        <span class="font-normal text-gray-500 dark:text-gray-400">Administrator</span>
                    </div>
                    <div class="mb-5">
                        <span class="font-semibold text-2xl text-gray-900 dark:text-white">{{ $user->messagetitlebelong->name  }}</span>
                    </div>
                    <div class="mb-5">
                        <span class="font-semibold text-md italic text-gray-900 dark:text-white">{{ $user->messagetitlebelong->title  }}</span>
                    </div>
                    @foreach ($user->messagetitlebelong->message as $message)
                    <div class="border-b-2 border-gray-400 pb-3">
                        <p class="font-normal py-2 text-gray-900 dark:text-white italic indent-5">{{ $message->description }}</p>
                        <small class="font-normal text-gray-500 dark:text-gray-400">{{ date('M d ,Y h:i a',strtotime($message->created_at)) }}</small>
                    </div>
                    @endforeach
                </div>
         </div>
    </div>
    </section>

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
