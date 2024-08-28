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
        @else
        @endif
        <div class="my-3">
            <form method="GET">
                <div class="relative">
                    <input type="search" id="default-search" name="search" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search... name , contact , room ">
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
        </div>
        <div class="card mb-4">
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Account name</th>
                            <th scope="col">Gcash Account</th>
                            <th scope="col">Time</th>
                            <th scope="col">Room</th>
                            <th scope="col">Catering</th>
                            <th scope="col">Proof of Payment</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            {{-- <th scope="col">Code</th> --}}
                            {{-- <th scope="col">Expiration</th> --}}
                            <th></th>
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

                                <td>{{ $booking->concatenated_foods_names }}</td>
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
                                <td>{{ $booking->partial }}</td>
                                <td>
                                    @if ($booking->payment==='pending')
                                        <span class="text-orange-500">Pending </span>
                                      @elseif($booking->payment==='done')
                                      <span class="text-green-500">Done </span>
                                      @elseif($booking->payment==='paid')
                                        <span>Fully Paid</span>
                                      @elseif($booking->payment==='expired')
                                        <span class="text-red-500">Not Paid</span>
                                      @else

                                      @endif
                                    </td>
                                {{-- <td>{{ $booking->concatenated_barcode }}</td> --}}
                                {{-- <td>

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

                                        </td> --}}

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
                                        {{-- <td>

                                        @if ($booking->payment==='expired')
                                            <button type="button" data-toggle="modal" data-target="#modalDelete-{{ $booking->concatenated_barcode }}" class="py-2 px-3 bg-orange-700 hover:bg-orange-600 text-white rounded-md shadow-md"><i class="fa fa-warning"></i></button>

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
                                                        <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400 text-center">Are you sure you want to put into Warning ?</h3>
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

                                </td> --}}
                                <td >
                                    <div  data-backdrop="static" data-keyboard="false" style="cursor: pointer;" data-toggle="modal" data-target="#exampleModal-{{ $booking->concatenated_barcode }}">
                                       @php
                                        if($booking!=null){

                                            if($booking->payment=='paid'){

                                                $qrcode = '';
                                                    $bookingArray = (array) $booking;
                                                    if (array_key_exists('concatenated_barcode', $bookingArray)) {
                                                        $bookingArray['Barcode'] = $bookingArray['concatenated_barcode'];
                                                        $bookingArray['Name'] = $bookingArray['name'];
                                                        $bookingArray['Contact'] = $bookingArray['contact'];

                                                        $bookingArray['Payment Status'] = $bookingArray['payment'];
                                                        $bookingArray['Gcash Prof'] = 'Valid';
                                                        $bookingArray['Partial Payment'] = $bookingArray['partial'];
                                                        $bookingArray['Unsettled Payment'] = $bookingArray['total'];


                                                        $array_start = explode(',',$booking->concatenated_start_time);
                                                        $array_end = explode(',',$booking->concatenated_end_time);
                                                        if(count($array_start)>1 && count($array_end)){
                                                            $bookingArray['Schedule'] = date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1]));
                                                            $bookingArray['Time'] = date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1]));
                                                        }else{
                                                            $bookingArray['Schedule'] =  date('M d',strtotime($booking->concatenated_start_time));
                                                            $bookingArray['Time'] = date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time));
                                                        }


                                                        $bookingArray['Cottage'] = $bookingArray['title'];
                                                        $bookingArray['Foods'] = $bookingArray['concatenated_foods_names'];
                                                        $bookingArray['Total Amount'] = $bookingArray['partial'];

                                                        unset($bookingArray['concatenated_barcode']);
                                                        unset($bookingArray['name']);
                                                        unset($bookingArray['title']);
                                                        unset($bookingArray['contact']);
                                                        unset($bookingArray['payment']);
                                                        unset($bookingArray['partial']);
                                                        unset($bookingArray['total']);
                                                        unset($bookingArray['concatenated_foods_names']);
                                                    }
                                                    $fieldsToRemove = ['user_id', 'expire', 'concatenated_foods_names','concatenated_start_time','concatenated_end_time','image','room_price','schedule_price','total','partial','warning_count'];
                                                    $bookingArray = array_diff_key($bookingArray, array_flip($fieldsToRemove));
                                                    $text = implode("\n", array_map(function ($key, $value) {
                                                        return "$key: " . ucfirst($value);
                                                    }, array_keys($bookingArray), $bookingArray));
                                                   echo $qrcode = QrCode::size(80,80)->color(34, 71, 114)->generate($text);
                                            }
                                        }
                                        @endphp
                                   </div>
                                   <div class="modal fade" id="exampleModal-{{ $booking->concatenated_barcode }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                        <div class="modal-body">
                                            @php
                                            if($booking!=null){
                                                if($booking->payment=='paid'){

                                                    $qrcode = '';
                                                    $bookingArray = (array) $booking;
                                                    if (array_key_exists('concatenated_barcode', $bookingArray)) {
                                                        $bookingArray['Barcode'] = $bookingArray['concatenated_barcode'];
                                                        $bookingArray['Name'] = $bookingArray['name'];
                                                        $bookingArray['Contact'] = $bookingArray['contact'];

                                                        $bookingArray['Payment Status'] = $bookingArray['payment'];
                                                        $bookingArray['Gcash Prof'] = 'Valid';
                                                        $bookingArray['Partial Payment'] = $bookingArray['partial'];
                                                        $bookingArray['Unsettled Payment'] = $bookingArray['total'];


                                                        $array_start = explode(',',$booking->concatenated_start_time);
                                                        $array_end = explode(',',$booking->concatenated_end_time);
                                                        if(count($array_start)>1 && count($array_end)){
                                                            $bookingArray['Schedule'] = date('M d',strtotime($array_start[0])).' to '.date('M d',strtotime($array_end[1]));
                                                            $bookingArray['Time'] = date('h i s a',strtotime($array_start[0])).'  ~ '.date('h i s a',strtotime($array_end[1]));
                                                        }else{
                                                            $bookingArray['Schedule'] =  date('M d',strtotime($booking->concatenated_start_time));
                                                            $bookingArray['Time'] = date('h i s a',strtotime($booking->concatenated_start_time)).'  ~ '.date('h i s a',strtotime($booking->concatenated_end_time));
                                                        }


                                                        $bookingArray['Cottage'] = $bookingArray['title'];
                                                        $bookingArray['Foods'] = $bookingArray['concatenated_foods_names'];
                                                        $bookingArray['Total Amount'] = $bookingArray['partial'];

                                                        unset($bookingArray['concatenated_barcode']);
                                                        unset($bookingArray['name']);
                                                        unset($bookingArray['title']);
                                                        unset($bookingArray['contact']);
                                                        unset($bookingArray['payment']);
                                                        unset($bookingArray['partial']);
                                                        unset($bookingArray['total']);
                                                        unset($bookingArray['concatenated_foods_names']);
                                                    }
                                                    $fieldsToRemove = ['user_id', 'expire', 'concatenated_foods_names','concatenated_start_time','concatenated_end_time','image','room_price','schedule_price','total','partial','warning_count'];
                                                    $bookingArray = array_diff_key($bookingArray, array_flip($fieldsToRemove));
                                                    $text = implode("\n", array_map(function ($key, $value) {
                                                        return "$key: " . ucfirst($value);
                                                    }, array_keys($bookingArray), $bookingArray));
                                                   echo $qrcode = QrCode::size(450,450)->color(34, 71, 114)->generate($text);
                                                }
                                            }
                                            @endphp
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
