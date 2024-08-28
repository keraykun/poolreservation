@extends('admin.layouts')
@section('content')
<div class="container">
    <div class="row">
        <div class="card mb-4">
               <div class="card-header">
                @if (Session::has('success'))
                {{-- <div class="text-lg my-2 text-green-600">{{ Session::get('success') }}</div> --}}
                <script>
                    Swal.fire({
                        text: 'Successfully ' + @json(Session::get('success')),
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: 'green',
                        confirmButtonText: 'Close'
                    })
                </script>
                @elseif(Session::has('danger'))
                {{-- <div class="text-lg my-2 text-red-600">{{ Session::get('danger') }}</div> --}}
                <script>
                Swal.fire({
                    text: 'Successfully ' + @json(Session::get('danger')),
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Close'
                })
                </script>
                @else
                @endif
               </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Full name</th>
                            <th scope="col">Gcash Account</th>
                            <th scope="col">Time</th>
                            <th scope="col">Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Code</th>
                            <th scope="col">Warning</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->contact }}</td>
                                <td>
                                    @php
                                    $array_start = explode(',',$booking->concatenated_start_time);
                                    $array_end = explode(',',$booking->concatenated_end_time);
                                    if(count($array_start)>1 && count($array_end)){
                                        echo date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1])).' - '.date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1]));
                                    }else{
                                        echo date('M d',strtotime($booking->concatenated_start_time)).' - '.date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time));
                                    }
                                    @endphp
                                </td>
                                {{-- <td>{{ date('M d',strtotime($booking->start_time)).' - '.date('h i s a',strtotime($booking->start_time)).' ~ '.date('h i s a',strtotime($booking->end_time)) }}</td> --}}
                                <td>{{ $booking->title }}</td>
                                <td>
                                <span class="">{{ $booking->payment }} </span>
                                </td>
                                <td>{{ $booking->concatenated_barcode }}</td>
                                <td>
                                    {{-- {{ $expiration = \Carbon\Carbon::parse(\Carbon\Carbon::now('Asia/Manila'))->diffForHumans($booking->expire) }} --}}
                                @if ($booking->payment=='pending')
                                   @php
                                   $toDay = \Carbon\Carbon::now('Asia/Manila');
                                   if ($toDay->gt($booking->expire)) {
                                      echo '<span class="text-red-500">Expired</span>';
                                   } else {
                                       echo  $toDay->diffForHumans($booking->expire).' Expiration ';
                                   }
                                   @endphp
                                @elseif($booking->payment=='expired')
                                    @php
                                    $toDay = \Carbon\Carbon::now('Asia/Manila');
                                    if ($toDay->gt($booking->expire)) {
                                    echo '<span class="text-red-500">Expired</span>';
                                    } else {
                                        echo  $toDay->diffForHumans($booking->expire).' Expiration ';
                                    }
                                    @endphp
                                @elseif($booking->payment=='paid')
                                    @php
                                    $toDay = \Carbon\Carbon::now('Asia/Manila');
                                    $array_end = explode(',',$booking->concatenated_end_time);
                                    if(count($array_end)>1){
                                        echo  $toDay->diffForHumans($array_end[1]).' Expiration ';
                                    }else{
                                        echo  $toDay->diffForHumans($booking->concatenated_end_time).' Expiration ';
                                    }
                                    @endphp
                                @endif

                                </td>
                                <td>@if ($booking->warning_count)
                                    <span class="text-danger font-bold text-md">{{($booking->warning_count) }}</span>
                                @else
                                    <span></span>
                                @endif
                               </td>
                                <td>
                                    @if ($booking->payment=='pending')
                                    <button type="button" data-toggle="modal" data-target="#exampleModal-{{ $booking->concatenated_barcode }}" class="py-2 px-3 bg-green-700 hover:bg-green-600 text-white rounded-md shadow-md">Paid</button>
                                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="exampleModal-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body flex flex-col items-center justify-center">
                                                <svg class="mx-auto text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" class="text-green-600" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to proceed <b>PAID</b>?</h3>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                               <form method="POST" action="{{ route('admin.bookings.paid',$booking->concatenated_barcode) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                   Mark as Paid
                                                 </button>
                                               </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    @elseif($booking->payment=='paid')
                                    <button type="button" data-toggle="modal" data-target="#exampleModal-{{ $booking->concatenated_barcode }}" class="py-2 px-3 bg-green-700 hover:bg-green-600 text-white rounded-md shadow-md">Done</button>
                                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="exampleModal-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body flex flex-col items-center justify-center">
                                                <svg class="mx-auto text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" class="text-green-600" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to proceed <b>PAID</b>?</h3>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                               <form method="POST" action="{{ route('admin.bookings.paid',$booking->concatenated_barcode) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                   Mark as Paid
                                                 </button>
                                               </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    @endif

                                </td>
                                <td>
                                    @php

                                    @endphp

                                </td>
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>
@endsection
