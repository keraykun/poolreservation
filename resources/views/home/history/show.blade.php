@extends('home.layout')
@section('content')
<main>

    @if (Auth::check())
    <section style="min-height:600px;" class="p-5 rounded-sm flex flex-col flex-wrap items-start justify-start w-full gap-5 ">
        <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto lg:py-0 mt-5 text-3xl font-bold" >
             Bookings Histories
        </div>
        <div class=" flex flex-col items-start justify-start  py-10 my-2 mx-auto  min-w-[50%] lg:py-0 mt-5"  style="border:1px solid #b0b0b0;   ">

        <div class="w-full" style=" box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
        -webkit-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="uppercase font-bold text-lg">
                        <th scope="col" class="px-6 py-3">
                            Barcode
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Room
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Feedback
                        </th>

                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                          {{ $booking->concatenated_barcode }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @php
                            $array_start = explode(',',$booking->concatenated_start_time);
                            $array_end = explode(',',$booking->concatenated_end_time);
                            if(count($array_start)>1 && count($array_end)){
                                echo date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1])).' - '.date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1]));
                            }else{
                                echo date('M d',strtotime($booking->concatenated_start_time)).' - '.date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time));
                            }
                            @endphp
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $booking->title }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                             {{ number_format($booking->total) }}
                        </th>
                         <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if ($booking->payment=="paid" || $booking->payment=="reserve")
                            <span class="text-green-500">{{ Str::ucfirst($booking->payment) }}</span>
                            @elseif($booking->payment=="pending")
                            <span class="text-orange-500">{{ Str::ucfirst($booking->payment) }}</span>
                            @elseif($booking->payment=="cancelled")
                            <span class="text-red-500">{{ Str::ucfirst($booking->payment) }}</span>
                             @elseif($booking->payment=="expired")
                            <span class="text-red-500">{{ Str::ucfirst($booking->payment) }}</span>
                           @elseif($booking->payment=="done")
                             <span class="text-green-500">{{ Str::ucfirst($booking->payment) }}</span>
                            @endif
                        </th>

                         <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                         <!-- Modal toggle -->
                        <button data-modal-target="default-modal-{{ $booking->id }}" data-modal-toggle="default-modal-{{ $booking->id }}" class="underline block text-slate-700  font-medium rounded-lg text-sm px-5 py-2.5 text-center " type="button">
                            Review
                        </button>

                        <!-- Main modal -->
                        <div id="default-modal-{{ $booking->id }}"  tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                                        <div  class="index-1 max-w-4xl text-slate-800 py-5 px-8 border gap-3 border-sky-700 drop-shadow-md bg-white"  style="border-radius:10px; box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
                                        -webkit-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
                                        -moz-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);">
                                            <section  id="toggleSummary" class="text-lg slide-in hidden-slide">
                                                <div class="py-1 border-dashed border-b-[2px] border-slate-400">
                                                    <ul>
                                                        <li><span>Name : </span><span class="font-bold">{{ auth()->user()->name }}</span>
                                                        </li>
                                                        <li><span>Schedule : </span>
                                                            <span class="font-bold break-words" id="summarySchedule">
                                                                @php
                                                                $array_start = explode(',',$booking->concatenated_start_time);
                                                                $array_end = explode(',',$booking->concatenated_end_time);
                                                                if(count($array_start)>1 && count($array_end)){
                                                                    echo date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1]));
                                                                }else{
                                                                    echo date('M d',strtotime($booking->concatenated_start_time));
                                                                }
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li><span>Expiration : </span>
                                                            <span class="font-bold break-words" id="summarySchedule">
                                                                @if ($booking->payment==='pending')
                                                                <span class="text-orange-500">{{ $booking->payment }} </span>
                                                                @elseif($booking->payment==='paid')
                                                               <span class="text-green-600">
                                                                  @php
                                                                  $toDay = \Carbon\Carbon::now('Asia/Manila');
                                                                  $array_end = explode(',',$booking->concatenated_end_time);
                                                                  if(count($array_end)>1){
                                                                      echo  $toDay->diffForHumans($array_end[1]).'  schedule done';
                                                                  }else{
                                                                      echo  $toDay->diffForHumans($booking->concatenated_end_time).' schedule done ';
                                                                  }
                                                                  @endphp
                                                               </span>
                                                              @elseif($booking->payment==='cancelled' || $booking->payment=="ended")
                                                                <span class="text-red-500">Expired</span>
                                                              @else

                                                              @endif
                                                            </span>
                                                        </li>
                                                        <li><span>Status : </span>
                                                            <span class="font-bold break-words" id="summarySchedule">
                                                                @if ($booking->payment=="paid" || $booking->payment=="reserve")
                                                                <span class="text-green-500">{{ Str::ucfirst($booking->payment) }}</span>
                                                                @elseif($booking->payment=="pending")
                                                                <span class="text-orange-500">{{ Str::ucfirst($booking->payment) }}</span>
                                                                @elseif($booking->payment=="cancelled")
                                                                 <span class="text-red-500">{{ Str::ucfirst($booking->payment) }}</span>
                                                                 @elseif($booking->payment=="expired")
                                                                 <span class="text-red-500">{{ Str::ucfirst($booking->payment) }}</span>
                                                               @elseif($booking->payment=="done")
                                                                 <span class="text-green-500">{{ Str::ucfirst($booking->payment) }}</span>
                                                                @endif
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="py-2 border-dashed border-b-[2px] border-slate-400 flex flex-col justify-between">
                                                    <span>Pool & Booking Fee</span>
                                                    <ul>
                                                        <li><span><i class="fa fa-clock"></i> Time : </span>
                                                            <span class="font-bold break-words" id="summaryTime">
                                                                @php
                                                                $array_start = explode(',',$booking->concatenated_start_time);
                                                                $array_end = explode(',',$booking->concatenated_end_time);
                                                                if(count($array_start)>1 && count($array_end)){
                                                                    echo date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1]));
                                                                }else{
                                                                    echo date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time));
                                                                }
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li><span><i class="fa fa-calculator"></i> Sub Total : </span><span class="font-bold text-blue-400" id="summaryTimeSub">{{ number_format($booking->schedule_price) }}</span></li>
                                                    </ul>
                                                </div>
                                                <div class="py-2 border-dashed border-b-[2px] border-slate-400 flex flex-col justify-between">
                                                    <span>Accomodation</span>
                                                    <ul>
                                                        <li><span><i class="fa fa-door-open"></i> Room : </span><span class="font-bold break-words" id="summaryRoom">{{ $booking->title }}</span></li>
                                                        <li><span><i class="fa fa-calculator"></i> Sub Total : </span><span class="font-bold text-blue-400" id="summaryRoomSub">{{ number_format($booking->room_price) }}</span></li>
                                                    </ul>
                                                </div>
                                                <div class="py-2 border-dashed border-b-[2px] border-slate-400 flex flex-col justify-between" id="olCaterings">
                                                    <span>Caterings</span>
                                                    <ul>
                                                        <li><span><i class="fa fa-cutlery"></i></i> Food : </span>
                                                            <span class="font-bold break-words" id="foodListSpan">
                                                                @php
                                                                $array_foods = explode(',',$booking->concatenated_foods_names);
                                                                if(count($array_foods)>1){
                                                                    echo implode(' , ',$array_foods);

                                                                }else{
                                                                    echo $booking->concatenated_foods_names;
                                                                }
                                                                @endphp
                                                            </span>
                                                        </li>
                                                        <li><span><i class="fa fa-calculator"></i> Sub Total : </span><span class="font-bold text-blue-400" id="subtotalSpan">{{ number_format($booking->food_price) }}</span></li>
                                                    </ul>
                                                </div>
                                                <div class="py-2flex flex-col justify-between mt-4">

                                                    <ul>
                                                        <li class="text-2xl"><span>TOTAL : </span><span class="font-bold text-blue-400" id="totalSummary">{{ number_format($booking->total) }}</span></li>
                                                    </ul>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </th>
                            <th scope="row" class="px-6 py-4 text-md text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($booking->payment=='done' && $booking->is_rated==null && $booking->gcash_code!=null || $booking->payment=='ended' && $booking->is_rated==null && $booking->gcash_code!=null)
                                <a href="{{ route('home.rating.show',$booking->id) }}">
                                    <small>No rating yet</small><br>
                                    <small>Click to rate</small>
                                </a>
                                @endif
                            </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        </div>

    </section>
    {{-- <section class="p-5 rounded-sm flex flex-col flex-wrap items-start justify-start w-full gap-5 ">
        <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto lg:py-0 mt-5 text-3xl font-bold" >
            My Book Histories
        </div>
        @foreach ($bookings as $booking)
        <div class="flex flex-col items-start justify-start px-6 py-10 my-2 mx-auto  min-w-[50%] lg:py-0 mt-5 relative"  style="border:1px solid #b0b0b0;">
              <ul class="list-none bg-white w-full text-xl">
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start ">
                    @if ($booking->payment=='done' && $booking->is_rated==null || $booking->payment=='ended' && $booking->is_rated==null)
                    <a href="{{ route('home.rating.show',$booking->id) }}" class="absolute right-0 top-0 p-2 text-white bg-orange-500" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;">
                        <small>No rating yet</small><br>
                        <small>Click to rate</small>
                    </a>
                    @endif
                    <span class="font-bold mr-[60px]">Name</span>
                    <span class="mr-10"> : </span>
                    <span>{{ $booking->name }}</span>
                </li>
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[60px]">Room</span>
                    <span class="mr-10"> : </span>
                    <span>{{ $booking->title }}</span>
                </li>
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[60px]">Room</span>
                    <span class="mr-10"> : </span>
                    <span>{{ $booking->concatenated_foods_names }}</span>
                </li>
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[32px]">Schedule</span>
                    <span class="mr-10"> : </span>
                    <span>
                        @php
                        $array_start = explode(',',$booking->concatenated_start_time);
                        $array_end = explode(',',$booking->concatenated_end_time);
                        if(count($array_start)>1 && count($array_end)){
                            echo date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1])).' - '.date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1]));
                        }else{
                            echo date('M d',strtotime($booking->concatenated_start_time)).' - '.date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time));
                        }
                        @endphp
                    </span>
                </li>
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[35px]">Payment</span>
                    <span class="mr-10"> : </span>
                   @if ($booking->payment=="paid")
                   <span class="text-green-500">{{ $booking->payment }}</span>
                   @elseif($booking->payment=="pending")
                   <span class="text-orange-500">{{ $booking->payment }}</span>
                   @elseif($booking->payment=="expired")
                    <span class="text-red-500">{{ $booking->payment }}</span>
                  @elseif($booking->payment=="done")
                    <span class="text-green-500">{{ $booking->payment }}</span>
                   @endif
                </li>
                <li class="py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[70px]">Code</span>
                    <span class="mr-10"> : </span>
                    <span class="text-slate-600">{{ $booking->concatenated_barcode.' ( Please show this to the Guard ) ' }}</span>
                </li>
              </ul>
        </div>
        @endforeach
    </section> --}}
    @else
    <section class="p-5 rounded-sm flex flex-row flex-wrap items-start justify-start w-full gap-5 ">
        <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto sm:h-screen lg:py-0 mt-5">
            <div class="w-full  rounded-lg  dark:border md:mt-0  xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <p class="text-3xl drop-shadow-sm text-slate-600">You need to login first to see your schedule. Click to <a href="{{ route('guest.index') }}" class="text-sky-700 font-bold">Login</a></p>
            </div>
        </div>
    </section>
    @endif


</main>

@endsection
