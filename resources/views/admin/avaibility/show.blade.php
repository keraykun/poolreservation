@extends('admin.layouts')
@section('content')
<main>
    @if (Auth::check())
    <div class="mt-5 flex flex-col items-center justify-center gap-5 p-5 relative">
        <div>
            <a class="py-2 px-3 bg-sky-700 text-white rounded-md shadow-md" href="{{ route('admin.availity.index') }}">Go back</a>
        </div>
        <div  class="index-1 max-w-7xl text-slate-800 py-5 px-8 border gap-3 border-sky-700 drop-shadow-md bg-white"  style="border-radius:10px; box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
        -webkit-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);">
            <section  id="toggleSummary" class="text-lg slide-in hidden-slide">
                <div class="py-1 border-dashed border-b-[2px] border-slate-400">
                    <ul>
                        <li><span>Name : </span><span class="font-bold" id="spanName" data-barcode="{{ $booking->concatenated_barcode }}" data-id="{{ $booking->user_id }}">{{ auth()->user()->name }}</span>
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
                            <span class="text-orange-500">{{ $expiration }} </span>
                                @elseif($booking->payment==='reserve')
                                <span id="spanPayment" class="text-green-600">Partial Paid</span>
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
                              @elseif($booking->payment==='expired')
                                <span class="text-red-500">Expired</span>
                              @else

                              @endif
                            </span>
                        </li>
                        <li><span>Status : </span>
                            <span class="font-bold break-words" id="summarySchedule">
                                @if ($booking->payment==='pending')
                                <span id="spanPayment" class="text-orange-500">Pending</span>
                              @elseif($booking->payment==='paid')
                                <span id="spanPayment" class="text-slime-600">Paid</span>
                              @elseif($booking->payment==='reserve')
                                <span id="spanPayment"><span  class="text-green-600">Partial Paid</span> <span class="font-sans"> ₱ ( {{ number_format($booking->partial??'') }} )</span></span>
                              @elseif($booking->payment==='expired')
                                <span id="spanPayment" class="text-red-500">Not Paid</span>
                              @else

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
                        <li><span><i class="fa fa-calculator"></i> Sub Total : </span><span class="font-bold text-blue-400" id="subtotalSpan">{{ number_format($booking->total_foods_price) }}</span></li>
                    </ul>
                </div>
                <div class="py-2flex flex-col justify-between mt-4">
                    <ul>
                        <li class="text-2xl"><span>TOTAL : </span>
                            <span class="font-bold text-blue-400" id="totalSummary">
                                @if ($booking->total==0)
                                {{ number_format($booking->partial) }}
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </section>
            <section id="showQrcodeToggle" style="display: none;">
                @if ($booking->payment=='paid')
                <div class="">
                    <span>{!! $qrcode !!}</span>
                    <div class="text-lg py-2 font-bold text-slate-700">Scan your QRCODE book here</div>
                </div>
                @elseif($booking->payment=='pending' || $booking->payment=='reserve')
                    @if($booking->barcode==null)
                        <form class="flex flex-col gap-2 max-w-7xl"  style="width: 700px; height:500px;">
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <!-- Remove this content if a file is selected or dropped -->
                                    <div id="dropzone-content" class="flex flex-col items-center justify-center pt-5 pr-3 pl-3 pb-6">
                                        <svg class="w-10 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xl text-gray-500 dark:text-gray-700">GCASH PROF OF PAYMENT</p>
                                    </div>
                                    <!-- File input -->
                                    <input id="dropzone-file" type="file" accept="image/png, image/jpg, image/jpeg" class="hidden" onchange="displayImage(this)" />

                                </label>
                            </div>
                            <div onclick="uploadGcash('{{ $booking->concatenated_barcode }}')" class="cursor-pointer text-md text-center py-2 px-3 font-bold text-slate-700 rounded-md shadow-md bg-sky-700 text-white">UPLOAD</div>
                        </form>
                    @else
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center justify-center w-full flex flex-col">
                                <div id="dropzone-content" class="flex flex-col items-center justify-center pt-5 pr-3 pl-3 pb-6">
                                    <div class="mb-4 text-gray-500 dark:text-gray-400 bg-cover">
                                        <img class="w-[700px] h-[500px] " src="{{ asset('images/gcash/'.$booking->image) }}" alt="">
                                    </div>
                                </div>
                                <p class="text-xl text-gray-500 dark:text-gray-700">GCASH PROF OF PAYMENT</p>
                            </div>
                        </div>
                    @endif
                @endif
            </section>
            {{-- <section class="text-center mt-5 font-bold uppercase flex gap-8 items-center justify-center text-sky-600 cursor-pointer">
               @if ($booking->payment=='pending')
               <span  onclick="toggleSliderUpload(this)" class="underline"> UPLOAD GCASH PROF OF PAYMENT</span>
               <small onclick="removeSchedule('{{ $booking->concatenated_barcode }}')" class="py-2 px-3 bg-red-600 text-white shadow-lg cursor-pointer text-md rounded-md">Delete</small>
             @elseif($booking->payment=='paid'  || $booking->payment=='reserve')
              <span class="flex items-center justify-evenly w-full gap-8">
                <span  onclick="toggleSlider(this)" class="underline"> Show QRCODE</span>
                <button type="button" onclick="showConfirmation('{{ $booking->concatenated_barcode }}')" class="py-2 px-3 bg-red-700 hover:bg-red-600 text-white rounded-md shadow-md">Mark as done</button>
              </span>
              @endif
            </section> --}}
        </div>
    </div>
<script>
  function toggleSliderUpload(e) {
    var sliderSection = document.getElementById("toggleSummary");
    sliderSection.classList.toggle("hidden-slide");
    if(sliderSection.classList.contains('hidden-slide')){
        $(e).text('UPLOAD GCASH PROF OF PAYMENT')
        sliderSection.classList.add('hidden-slide')
        $('#showQrcodeToggle').css('display','none')
        $('#toggleSummary').css('display','inline')
    }else{
        $(e).text('GO BACK')
        sliderSection.classList.remove('hidden-slide')
        $('#showQrcodeToggle').css('display','inline')
        $('#toggleSummary').css('display','none')
    }
  }

  function toggleSlider(e) {
    var sliderSection = document.getElementById("toggleSummary");
    sliderSection.classList.toggle("hidden-slide");
    if(sliderSection.classList.contains('hidden-slide')){
        $(e).text('SHOW QRCODE')
        sliderSection.classList.add('hidden-slide')
        $('#showQrcodeToggle').css('display','none')
        $('#toggleSummary').css('display','inline')
    }else{
        $(e).text('HIDE QRCODE')
        sliderSection.classList.remove('hidden-slide')
        $('#showQrcodeToggle').css('display','inline')
        $('#toggleSummary').css('display','none')
    }
  }
</script>

    {{-- <section class="p-5 rounded-sm flex flex-row flex-wrap items-center justify-center w-full gap-5">
        <div class="flex flex-col relative items-start justify-start px-6 py-8 min-w-[50%] lg:py-0 mt-5" style="border:1px solid #b0b0b0;">

            <ul class="list-none bg-white w-full text-xl">
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[80px]">Name</span>
                    <span class="mr-10"> : </span>
                    <span id="spanName" data-id="{{ $booking->user_id }}">{{ $booking->name }}</span>
                </li>
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[80px]">Room</span>
                    <span class="mr-10"> : </span>
                    <span id="spanRoom">{{ $booking->title }}</span>
                </li>
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[80px]">Foods</span>
                    <span class="mr-10"> : </span>
                    <span id="spanFood">
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
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[53px]">Schedule</span>
                    <span class="mr-10"> : </span>
                    <span id="spanSchedule">
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
                    <span class="font-bold mr-[53px]">Expiration</span>
                    <span class="mr-10"> : </span>
                    <span id="spanSchedule">
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
                    <span class="font-bold mr-[55px]">Payment</span>
                    <span class="mr-10"> : </span>
                    @if ($booking->payment==='pending')
                      <span id="spanPayment" class="text-orange-500">Pending</span>
                    @elseif($booking->payment==='paid')
                      <span id="spanPayment" class="text-green-600">Paid</span>
                    @elseif($booking->payment==='expired')
                      <span id="spanPayment" class="text-red-500">Not Paid</span>
                    @else

                    @endif
                </li>
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[40px]">Expiration</span>
                    <span class="mr-10"> : </span>
                    @if ($booking->payment==='pending')
                      <span class="text-orange-500">{{ $expiration }} </span>
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
                    @elseif($booking->payment==='expired')
                      <span class="text-red-500">Expired</span>
                    @else

                    @endif
                </li>
                <li class="border-b-2 border-slate-300 py-2 px-3 flex justify-start">
                    <span class="font-bold mr-[85px]">Code</span>
                    <span class="mr-10"> : </span>
                    <span id="spanBarcode" class="text-slate-600">{{ $booking->concatenated_barcode }}</span>
                </li>
                @if ($booking->payment=='pending')
                <li class="border-b-2 border-slate-300 py-5 flex justify-around flex-col">
                    <span class="text-orange-500 underline px-5 ">Please pay the reservation. or else the reserve that you create it will expire before 1 hour</span>
                     <ul class="text-slate-600">
                        <li class="border-b-2 border-slate-300 py-2 px-5 flex justify-start">
                            <span class="font-bold mr-[120px]">Gcash</span>
                            <span class="mr-10"> : </span>
                            <span>0919384373</span>
                        </li>
                        <li class="border-b-2 border-slate-300 py-2 px-5 flex justify-start">
                            <span class="font-bold mr-[60px]">Gcash name</span>
                            <span class="mr-10"> : </span>
                            <span>Alejandro</span>
                        </li>
                     </ul>
                </li>
                @elseif ($booking->payment=='paid')
                    <li class="py-2 px-3 flex justify-start">
                        <button type="button" onclick="showConfirmation('{{ $booking->concatenated_barcode }}')" class="py-2 px-3 bg-green-700 hover:bg-green-600 text-white rounded-md shadow-md">Mark as done</button>

                    </li>
                @endif
              </ul>
        </div>
        @if ($booking->payment=='paid')
        <div class="">
            <span>{!! $qrcode !!}</span>
            <div class="text-lg py-2 font-bold text-slate-700">Scan your QRCODE book here</div>
        </div>
        @elseif($booking->payment=='pending')
            @if($booking->barcode==null)
                <form class="flex flex-col gap-2">
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <!-- Remove this content if a file is selected or dropped -->
                            <div id="dropzone-content" class="flex flex-col items-center justify-center pt-5 pr-3 pl-3 pb-6">
                                <svg class="w-10 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-700">GCASH PROF OF PAYMENT</p>
                            </div>
                            <!-- File input -->
                            <input id="dropzone-file" type="file" accept="image/png, image/jpg, image/jpeg" class="hidden" onchange="displayImage(this)" />

                        </label>
                    </div>
                    <div onclick="uploadGcash('{{ $booking->concatenated_barcode }}')" class="cursor-pointer text-md text-center py-2 px-3 font-bold text-slate-700 rounded-md shadow-md bg-sky-700 text-white">UPLOAD</div>
                </form>
            @else
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-center w-full flex flex-col">
                        <div id="dropzone-content" class="flex flex-col items-center justify-center pt-5 pr-3 pl-3 pb-6">
                            <div class="mb-4 text-gray-500 dark:text-gray-400 bg-cover">
                                <img class="w-[228px] h-[252px] " src="{{ asset('images/gcash/'.$booking->image) }}" alt="">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-700">GCASH PROF OF PAYMENT</p>
                    </div>
                </div>
            @endif
        @endif
    </section> --}}
    @else
    <section class="p-5 rounded-sm flex flex-row flex-wrap items-start justify-start w-full gap-5">
        <div class="flex flex-col items-start justify-start px-6 py-8 mx-auto sm:h-screen lg:py-0 mt-5">
            <div class="w-full  rounded-lg  dark:border md:mt-0  xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <p class="text-3xl drop-shadow-sm text-slate-600">You need to login first to see your schedule. Click to <a href="{{ route('guest.index') }}" class="text-sky-700 font-bold">Login</a></p>
            </div>
        </div>
    </section>
    @endif
    <script>
   function displayImage(input) {
    const file = input.files[0];

    if (file) {
        // Remove the content within the dropzone
        const dropzoneContent = document.getElementById('dropzone-content');
        if (dropzoneContent) {
            dropzoneContent.remove();
        }

        const reader = new FileReader();

        reader.onload = function (e) {
            // Display the uploaded image within the dropzone
            const dropzoneLabel = input.parentElement;
            dropzoneLabel.style.backgroundImage = `url('${e.target.result}')`;
            dropzoneLabel.style.backgroundSize = 'cover';
            dropzoneLabel.style.backgroundPosition = 'center';
            // Set the width and height to match the previous content
            dropzoneLabel.style.width = '700px';
            dropzoneLabel.style.height = '450px';
        };

        // Read the file as a data URL
        reader.readAsDataURL(file);
    }
}
    function uploadGcash(id){
        console.log(id)
                // Create a FormData object to handle the file upload
        var formData = new FormData();
        formData.append('file', $('#dropzone-file')[0].files[0]);
        formData.append('barcode',id)
            // Perform the AJAX request
        formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: "{{ route('home.gcash.store') }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var redirectToPage = "{{ route('home.bookings.show', '') }}" + '/' + response.userID;
                    Swal.fire({
                        title: "Gcash has been uploaded...",
                        text: response.message,
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: true,
                    }).then(() => {
                        window.location.href = redirectToPage;
                    });
                },
                error: function(error) {
                    console.error(error);
                }
        });
    }
    function showConfirmation(id) {
        var txtData = {
            'food':$('#subtotalSpan').text(),
            'user_id':$('#spanName').data('id'),
            'barcode':$('#spanName').data('barcode'),
            'name':$('#spanName').text(),
            'schedule':$('#spanSchedule').text(),
            'payment':$('#spanPayment').text(),
            // 'barcode':$('#spanBarcode').text(),
            'room':$('#spanRoom').text(),
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'this would be the end of your schedule',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Mark as done',
            allowOutsideClick: false,

        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                type: 'POST',
                url: "{{ route('home.rating.done') }}",
                data:txtData,
                success: function(response) {
                    console.log(response)
                    var redirectToPage = "{{ route('home.rating.show', '') }}" + '/' + response.id;
                    Swal.fire({
                        title: "Redirecting...",
                        text: "You will be redirected in a moment.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = redirectToPage;
                    });
                },
                error: function(error) {
                    console.error('Error:', error);
                    // Handle error here
                }
            });
            }
        });
    }

    function removeSchedule(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'this would be deleted',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete',
            allowOutsideClick: false,

        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                type: 'DELETE',
                url: "{{ route('home.bookings.destroy', '') }}" + '/' + id,
                data:id,
                success: function(response) {
                    var redirectToPage = "{{ route('home.booked.show', '') }}" + '/' + response.id;
                    Swal.fire({
                        title: "Redirecting...",
                        text: "You will be redirected in a moment.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = redirectToPage;
                    });
                },
                error: function(error) {
                    console.error('Error:', error);
                    // Handle error here
                }
            });
            }
        });
    }
    </script>
</main>

@endsection
