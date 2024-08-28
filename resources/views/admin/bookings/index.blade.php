@extends('admin.layouts')
@section('content')
<div class="container">
    <div class="row">
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
        @elseif(Session::has('file'))
        {{-- <div class="text-lg my-2 text-red-600">{{ Session::get('danger') }}</div> --}}
        <script>
        Swal.fire({
            text: @json(Session::get('file')),
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Close'
        })
        </script>
        @else
        @endif
        <div class="card mb-4">
                <div class="card-body">
                    <div class="my-3">
                        <form method="GET" class="flex gap-3">
                            <div class="form-group w-full">
                                <input type="text" name="search" placeholder="Search. name | contact | room" class="form-control">
                            </div>
                            <div class="form-group w-full">
                                <button class="bg-sky-700 text-white hover:bg-sky-600 btn" type="submit" class="form-control">Search</button>
                            </div>
                        </form>
                    </div>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Account name</th>
                            <th scope="col">Gcash Account</th>
                            <th scope="col">Payment</th>
                            {{-- <th scope="col">Status</th> --}}
                            {{-- <th scope="col">Code</th> --}}
                            <th scope="col">Balance</th>
                            <th scope="col">Partial</th>
                            {{-- <th scope="col">Expiration</th> --}}
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->contact }}</td>
                                <td>
                                    @if ($booking->image!=null)
                                    <img class="w-[80px] h-[80px] cursor-pointer"  src="{{ asset('images/gcash/'.$booking->image) }}" data-toggle="modal" data-target="#modalPicture-{{ $booking->concatenated_barcode }}" alt="">
                                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalPicture-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="modalPictureLabel" aria-hidden="true">
                                        <form method="POST" class="w-full" action="{{ route('admin.bookings.partial',$booking->concatenated_barcode) }}">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <img class="w-full h-[500px]" src="{{ asset('images/gcash/'.$booking->image) }}">
                                            </div>
                                          </div>
                                        </div>
                                    </form>
                                    </div>
                                    @endif
                                </td>
                                <td>₱ {{number_format( $booking->total) }}</td>
                                <td class="text-sky-600">₱ {{number_format( $booking->partial) }}</td>
                                <td>

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
                                <td>
                                    @if ($booking->image!=null)
                                         @if ($booking->payment!='expired')
                                        @if ($booking->partial_status==0)
                                        <button type="button" data-toggle="modal" data-target="#exampleModal-{{ $booking->concatenated_barcode }}" class="py-2 px-3 mb-2 bg-lime-500 hover:bg-lime-500 text-white shadow-md" style="border-radius: 20px;">Partial Paid</button>
                                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="exampleModal-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form method="POST" class="w-full" action="{{ route('admin.bookings.partial',$booking->concatenated_barcode) }}">
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
                                                    <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to proceed <b>PARTIAL PAID</b>?</h3>
                                                    <input type="hidden" name="booking_total" value="{{ $booking->total }}">
                                                    <input
                                                    pattern="[0-9]+"
                                                    name="partial_amount"
                                                    title="Please enter numbers only"
                                                    placeholder="Enter the amount to partial" type="text" id="small-input" class="block w-full p-2 mt-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-lime-500 hover:bg-lime-500 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        Mark as Partial
                                                        </button>
                                                </div>
                                                </div>
                                            </div>
                                         </form>
                                        </div>
                                        @else

                                        <button type="button" data-toggle="modal" data-target="#editModalPartial-{{ $booking->concatenated_barcode }}" class="py-2 px-3 mb-2 bg-sky-500 hover:bg-sky-500 text-white shadow-md" style="border-radius: 20px;">Edit Partial</button>

                                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="editModalPartial-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form method="POST" class="w-full" action="{{ route('admin.bookings.partialupdate',$booking->concatenated_barcode) }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body flex flex-col items-center justify-center">
                                                    <svg class="mx-auto text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                        <path stroke="currentColor" class="text-sky-600" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                    </svg>
                                                    <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to update <b>PARTIAL PAID</b>?</h3>
                                                    <input type="hidden" name="booking_total" value="{{ $booking->total }}">
                                                    <input type="hidden" name="booking_partial" value="{{ $booking->partial }}">
                                                    <input
                                                    pattern="[0-9]+"
                                                    value="{{ $booking->partial }}"
                                                    name="partial_amount"
                                                    title="Please enter numbers only"
                                                    placeholder="Enter the amount to partial" type="text" id="small-input" class="block w-full p-2 mt-3 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-sky-500 hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                       Update Partial
                                                        </button>
                                                </div>
                                                </div>
                                            </div>
                                         </form>
                                        </div>

                                        @endif
                                            <button type="button" data-toggle="modal" data-target="#partialPAID-{{ $booking->concatenated_barcode }}" class="py-2 px-3  mb-2 bg-green-700 hover:bg-green-600 text-white rounded-md shadow-md" style="border-radius: 20px;">Fully Paid</button>
                                            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="partialPAID-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                        <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to proceed <b>FULLY PAID</b>?</h3>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                                    <form method="POST" action="{{ route('admin.bookings.paid',$booking->concatenated_barcode) }}">
                                                        <input type="hidden" value="{{ $booking->total }}" name="total">
                                                        <input type="hidden" value="{{ $booking->partial }}" name="partial">
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
                                        </div>
                                    @endif

                                    @else

                                    <div id="upload-container" class="flex items-center">
                                        <label for="file-input" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="showUpload()">
                                            Upload
                                        </label>
                                        <form id="upload-form" class="hidden ml-4 my-2" action="{{ route('admin.bookings.store') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file" id="file-input" class="hidden">
                                            <input type="hidden" value="{{ $booking->concatenated_barcode }}" name="barcode">
                                            <button type="submit" class="bg-green-500 mb-3 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                            <button type="button" onclick="cancelUpload()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                                        </form>
                                    </div>

                                    <script>
                                        function showUpload() {
                                            document.getElementById('upload-form').classList.remove('hidden');
                                        }

                                        function cancelUpload() {
                                            document.getElementById('upload-form').classList.add('hidden');
                                        }
                                    </script>

                                    @endif
                                </td>
                                {{-- <td>
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
                                    @elseif($booking->payment=='reserve')
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

                                </td> --}}
                                <td>

                                   @if ($booking->payment==='expired')
                                   <button type="button" data-toggle="modal" data-target="#modalDelete-{{ $booking->concatenated_barcode }}" class="py-2 px-3 bg-orange-700 hover:bg-orange-600 text-white rounded-md shadow-md"><i class="fa fa-trash"></i></button>

                                   <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalDelete-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                       <div class="modal-dialog">
                                         <div class="modal-content">
                                           <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                             </button>
                                           </div>
                                           <div class="modal-body flex flex-col items-center justify-center">
                                               <svg class="mx-auto text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                   <path stroke="currentColor" class="text-orange-600" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                               </svg>
                                               <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400 text-center">Are you sure you want to Delete?</h3>
                                           </div>
                                           <div class="modal-footer">
                                             <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                              <form method="POST" action="{{ route('admin.bookings.warning') }}">
                                               @csrf
                                               <input type="hidden" value="{{ $booking->title }}" name="title">
                                               <input type="hidden" value="{{ $booking->concatenated_barcode }}" name="barcode">
                                               <input type="hidden" value="{{ $booking->user_id }}" name="user_id">
                                               <input type="hidden" value="{{ $booking->payment }}" name="payment">
                                               @php
                                               $array_start = explode(',',$booking->concatenated_start_time);
                                               $array_end = explode(',',$booking->concatenated_end_time);
                                               if(count($array_start)>1 && count($array_end)){
                                                   echo '<input name="date_booked" type="hidden" value="'.date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1])).' - '.date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1])).'"/>';
                                               }else{
                                                   echo '<input name="date_booked" type="hidden" value="'.date('M d',strtotime($booking->concatenated_start_time)).' - '.date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time)).'"/>';
                                               }
                                               @endphp
                                               <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-orange-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                   Mark as Warning
                                                </button>
                                              </form>
                                           </div>
                                         </div>
                                       </div>
                                     </div>
                                     @endif
                                </td>
                                <td>
                                    <button type="button" data-toggle="modal" data-target="#detailModals-{{ $booking->concatenated_barcode }}" class="py-2 px-3 bg-sky-700 hover:bg-sky-600 text-white rounded-md shadow-md">Schedule</button>

                                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="detailModals-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content bg-white rounded shadow-lg">
                                            <div class="modal-header border-b py-2">
                                                <h6 class="modal-title text-2xl font-bold uppercase">Booking Schedule</h6>
                                                <button type="button" class="text-gray-500 hover:text-gray-700" data-dismiss="modal">
                                                  <span>&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <p class="mb-4"> </p>
                                                <ul class="list-disc pl-4">
                                                  <li class="mb-2">
                                                    @php
                                                    $array_start = explode(',',$booking->concatenated_start_time);
                                                    $array_end = explode(',',$booking->concatenated_end_time);
                                                    if(count($array_start)>1 && count($array_end)){
                                                        echo date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1])).' - '.date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1]));
                                                    }else{
                                                        echo date('M d',strtotime($booking->concatenated_start_time)).' - '.date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time));
                                                    }
                                                    @endphp
                                                  </li>
                                                  <li class="mb-2">
                                                    {{ $booking->concatenated_foods_names }}
                                                  </li>
                                                  <li class="mb-2">{{ $booking->title }}</li>

                                                </ul>
                                              </div>
                                            <div class="modal-footer">
                                              <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>

                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </td>
                                <td >
                                    <button type="button" data-toggle="modal" data-target="#modalMessage-{{ $booking->concatenated_barcode }}" class="py-2 px-3 bg-orange-700 hover:bg-orange-600 text-white rounded-md shadow-md"><i class="fa fa-warning"></i></button>

                                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalMessage-{{ $booking->concatenated_barcode }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body flex flex-col items-center justify-center">
                                                <svg class="mx-auto text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" class="text-orange-600" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                                <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400 text-center">Are you sure you want to Delete?</h3>
                                            </div>
                                            <div class="modal-footer">

                                               <form class="flex flex-col gap-3 w-full" method="POST" action="{{ route('admin.bookings.delete') }}">
                                                @csrf
                                                <div class="relative bg-white dark:bg-gray-700">
                                                    <!-- Modal body -->
                                                    <div class="p-4 md:p-5 space-y-4">
                                                    {{-- <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                                                     <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Title"> --}}
                                                    <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..."></textarea>
                                                    <input type="hidden" value="{{ $booking->title }}" name="title">
                                                    <input type="hidden" value="{{ $booking->concatenated_barcode }}" name="barcode">
                                                    <input type="hidden" value="{{ $booking->user_id }}" name="user_id">
                                                    <input type="hidden" value="{{ $booking->payment }}" name="payment">
                                                </div>
                                                </div>
                                                @php
                                                $array_start = explode(',',$booking->concatenated_start_time);
                                                $array_end = explode(',',$booking->concatenated_end_time);
                                                if(count($array_start)>1 && count($array_end)){
                                                    echo '<input name="date_booked" type="hidden" value="'.date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1])).' - '.date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1])).'"/>';
                                                }else{
                                                    echo '<input name="date_booked" type="hidden" value="'.date('M d',strtotime($booking->concatenated_start_time)).' - '.date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time)).'"/>';
                                                }
                                                @endphp
                                               <div>
                                                <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-orange-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-1.5 text-center mr-2">
                                                    <i class="fa fa-trash text-lg"></i>
                                                 </button>
                                                 <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>

                                               </div>
                                                </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </td>
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div class="mt-4">
                        {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>
@endsection
