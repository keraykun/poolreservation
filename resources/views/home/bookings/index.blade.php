@extends('home.layout')
@section('content')
<main>
<style>
#calendar {
  max-width: 700px;
  margin: 0 auto;
  border:1px solid rgb(14, 92, 123);
}
.fc-daygrid-event.fc-daygrid-dot-event{
    background: white;
    color: #686868;
}
.fc-header-toolbar{
    background: rgb(14, 122, 165);
    color: white;
    padding: 5px 50px;
}
.fc-daygrid-day-frame{
    padding: 5px;
}
.fc-daygrid-day-frame:hover{
   background: rgb(234, 224, 224);

}


.fc-daygrid-day{
    border:1px solid rgb(209, 231, 238)!important;
}
.fc-daygrid-day.fc-day-disabled{
    background: rgb(227, 232, 233);
    cursor: not-allowed;
    pointer-events: all !important;
    cursor: not-allowed;
}
.fc-event {
  background-color: #337ab7;
  color: #fff;
  border: none;
}
.fc-media-screen.fc-direction-ltr.fc-theme-standard{
    margin: 0px !important;
    width: 100% !important;
}

.fc-today {
  background-color: #dff0d8;
}
.bookClasses{
    font-weight: bold;
}
input[type="checkbox"] {
  width: 30px; /* Adjust the width as needed */
  height: 30px; /* Adjust the height as needed */

}
input[type="checkbox"]:focus{
    outline: none !important;
    width: none;
}

#olFoodList::-webkit-scrollbar {
  width: 12px; /* Adjust the width of the scrollbar */
}

#olFoodList::-webkit-scrollbar-thumb {
  background-color: #12476a !important ; /* Change the color of the thumb (the draggable part) */
}

#olFoodList::-webkit-scrollbar-track {
 margin-top: 35px;
 margin-bottom: 35px;
}

#toggleSummary {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease-in-out; /* Adjust the duration and timing function as needed */
}

#toggleSummary.active {
    max-height: 1400px; /* Adjust the maximum height as needed */
}

#toggleSum {
    transform: rotate(90deg);
    transition: transform 0.5s ease-in-out; /* Adjust the duration and timing function as needed */
}

#calendar{
    max-width: 1100px;
    width: 100%;
}
.fc-daygrid-event-dot{
    border-width:10px;
    border-radius: 50%;

}
</style>

    {{-- @if (Auth::check()) --}}
        <section class="p-5 flex flex-row items-start justify-start w-full gap-5 relative">
            <div class="flex-col flex w-full gap-5">
                <div class="flex gap-4">
                    <div class="max-w-sm w-[360px] h-[310px] border border-sky-700 drop-shadow-md ">
                        <div class="py-5 bg-sky-700 text-2xl font-bold text-white text-center">
                            TIME
                        </div>
                        <div class="p-5" id="timeDiv">
                            <ol class="mb-3 px-5 flex gap-2 flex-col  text-gray-700 dark:text-gray-400 font-bold" id="olTimeList">
                                <li class="flex items-center gap-3 font-normal">
                                    <p class="text-lg font-bold text-slate-700">Please select your booking schedule on the above calendar</p>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="max-w-sm w-[360px] h-[310px] border border-sky-700 drop-shadow-md ">
                        <div class="py-5 bg-sky-700 text-2xl font-bold text-white text-center">
                            ROOM
                        </div>
                        <div class="p-5">
                            <ol class="mb-3 p-5 flex gap-2 flex-col pt-5  text-gray-700 dark:text-gray-400 font-bold" id="olRoomList" style="visibility:hidden;">
                                <li class="flex items-center gap-3 font-normal">
                                    <input type="checkbox" id="room0" name="title" value="none" onclick="roomCheckbox(this,'room0')">
                                    <label for="" class="flex items-center w-full justify-between"><span  class="font-bold ">None</span><small>0</small></label>
                                </li>
                                @foreach ($rooms as $key => $room)
                                    <li class="flex items-center gap-3 font-normal">
                                        <input type="checkbox" id="room{{ $key+1 }}" name="title" value="{{ $room->name }}" onclick="roomCheckbox(this,'room{{ $key+1 }}')">
                                        <label for="" class="flex items-center w-full justify-between"><span  class="font-bold ">{{ $room->name }}</span><small>{{ number_format($room->price) }}</small></label>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                    <div class="max-w-sm w-[360px] border border-sky-700 drop-shadow-md ">
                        <div class="py-5 bg-sky-700 text-2xl font-bold text-white text-center">
                            FOOD MENU
                        </div>
                        <div class="p-5" style="height: 230px; overflow-y:scroll; visibility:hidden;" id="olFoodList">
                            <ol class="mb-3 p-5 flex gap-2 flex-col  pt-5 text-gray-700 dark:text-gray-400 font-bold">
                                <li class="flex items-center gap-3 font-normal">
                                    <input type="checkbox" id="food-1" value="none" name="food" onclick="foodCheckbox(this,'food-1')">
                                    <label for="" class="w-full flex items-center justify-between"><span class="font-bold">None</span><small >{{ number_format(0) }}</small></label>
                                </li>
                                @foreach ($foods as $key => $food)
                                    <li class="flex items-center gap-3 font-normal">
                                        <input type="checkbox" id="{{ 'food'.$key }}" value="{{ $food->name }}" name="food[]" onclick="foodCheckbox(this,{{ $key }})">
                                        <label for="" class="w-full flex items-center justify-between"><span class="font-bold">{{ $food->name }}</span><small > {{ number_format($food->price) }}</small></label>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div class="w-full" id="calendar">
                        <span class="flex justify-around my-1">
                            <span class="flex justify-center items-center">
                                <span style="width: 15px; height: 15px; border: 1px solid rgba(12, 178, 228, 1); margin-right:10px;"></span>
                                <span> Available</span>
                            </span>
                            <span class="flex justify-center items-center">
                                <span style="border-radius:50%; width: 15px; height: 15px;background-color: rgba(12, 178, 228, 1); margin-right:10px;"></span>
                                <span> Pending</span>
                            </span>
                            <span class="flex justify-center items-center">
                                <span style="border-radius:50%; width: 15px; height: 15px;background-color:green; margin-right:10px;"></span>
                                <span> Reserve</span>
                            </span>
                            <span class="flex justify-center items-center">
                                <span style="border-radius:50%; width: 15px; height: 15px;background-color: red;margin-right:10px;"></span>
                                <span> Unavailable</span>
                            </span>
                        </span>
                    </div>
                    <div style="width:100%;" id="bookListData">

                    </div>
                </div>
            </div>
            <div>
               <div  class="index-1 max-w-sm  w-[400px] text-slate-800 p-4 border border-sky-700 drop-shadow-md bg-white">
                    <div class="py-3 text-2xl font-bold border-b-2 border-slate-400  text-center">
                        Reservation Summary
                    </div>
                    <section  id="toggleSummary" class="text-lg">
                        <div class="py-1 border-dashed border-b-[2px] border-slate-400">
                            <ul>
                                <li><span>Name : </span><span class="font-bold">{{ auth()->user()->name??'' }}</span></li>
                                <li><span>Schedule : </span><span class="font-bold break-words" id="summarySchedule">-------</span></li>
                            </ul>
                        </div>
                        <div class="py-2 border-dashed border-b-[2px] border-slate-400 flex flex-col justify-between">
                            <span>Pool & Booking Fee</span>
                            <ul>
                                <li><span><i class="fa fa-clock"></i> Time : </span><span class="font-bold break-words" id="summaryTime">-------</span></li>
                                <li><span><i class="fa fa-calculator"></i> Sub Total : </span><span class="font-bold text-blue-400" id="summaryTimeSub">0</span></li>
                            </ul>
                        </div>
                        <div class="py-2 border-dashed border-b-[2px] border-slate-400 flex flex-col justify-between">
                            <span>Accomodation</span>
                            <ul>
                                <li><span><i class="fa fa-door-open"></i> Room : </span><span class="font-bold break-words" id="summaryRoom">-------</span></li>
                                <li><span><i class="fa fa-calculator"></i> Sub Total : </span><span class="font-bold text-blue-400" id="summaryRoomSub">0</span></li>
                            </ul>
                        </div>
                        <div class="py-2 border-dashed border-b-[2px] border-slate-400 flex flex-col justify-between" id="olCaterings">
                            <span>Caterings</span>
                            <ul>
                                <li><span><i class="fa fa-cutlery"></i></i> Food : </span><span class="font-bold break-words" id="foodListSpan">-------</span></li>
                                <li><span><i class="fa fa-calculator"></i> Sub Total : </span><span class="font-bold text-blue-400" id="subtotalSpan">0</span></li>
                            </ul>
                        </div>
                        <div class="py-2flex flex-col justify-between mt-4">
                            <ul>
                                <li class="text-2xl"><span>Total : </span><span class="font-bold text-blue-400" id="totalSummary">0</span></li>
                            </ul>
                        </div>
                    </section>
                    <div class="py-2 flex flex-col justify-between mt-3 relative">
                        @if (Auth::check())
                        <button class="bg-sky-700 py-1 px-4 cursor-pointer rounded-md text-white text-md hover:bg-sky-600" type="button" id="formBtn">Proceed to Payment <i class="fa fa-credit-card"></i></button>
                        @else
                        <button class="bg-sky-700 py-1 px-4 cursor-pointer rounded-md text-white text-md hover:bg-sky-600"  onclick="showSweetAlert()" type="button">Proceed to Payment <i class="fa fa-credit-card"></i></button>
                        @endif
                    </div>
                    <button id="toggleSum" class="bg-sky-800 cursor-pointer rounded-md text-white absolute top-[50px] right-[-72px] px-2 text-md shadow-md" type="button" onclick="toggleContainer()">Show Summary</button>
                </div>
            </div>
        </section>

        @if (Auth::check() && $booking)
    @php
        $lastWarningTime = session('last_warning_time', 0);
        $currentTimestamp = now()->timestamp;
        $oneDayInSeconds = 24 * 60 * 60; // 1 day in seconds

        $showWarning = true;

        if ($currentTimestamp - $lastWarningTime <= $oneDayInSeconds) {
            // If a warning was already shown today, do not show it again
            $showWarning = false;
        }

        if ($showWarning) {
            // Show the warning
    @endphp
            <script>
                // Function to set a cookie
                function setCookie(name, value, days) {
                    var expires = "";
                    if (days) {
                        var date = new Date();
                        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                        expires = "; expires=" + date.toUTCString();
                    }
                    document.cookie = name + "=" + value + expires + "; path=/";
                }

                // Function to get a cookie value
                function getCookie(name) {
                    var nameEQ = name + "=";
                    var ca = document.cookie.split(';');
                    for (var i = 0; i < ca.length; i++) {
                        var c = ca[i];
                        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                    }
                    return null;
                }

                var cookieName = 'warning_shown_today';
                var hasWarningBeenShownToday = getCookie(cookieName);

                if (!hasWarningBeenShownToday) {
                    Swal.fire({
                        title: 'Account Warning',
                        text: 'Your account has a {{$booking}} warning for not attending the booked you created.',
                        icon: 'info',
                        allowOutsideClick: false,
                        confirmButtonText: 'Don\'t show again today',
                        showCancelButton: true,
                        cancelButtonText: 'OK',
                    }).then((result) => {
                        if (result.value) {
                            // User clicked OK, set a cookie to indicate that the warning has been shown today
                            setCookie(cookieName, 'true', 1); // Expires in 1 day
                        }
                    });
                }
            </script>
    @php
        }
    @endphp
@endif


        {{-- @if (Auth::check() && $booking)
        <script>
            Swal.fire({
            title:'Account Warning',
            text: 'Your account has a '+{{ $booking }}+' warning for not attending the booked you created.',
            icon: 'info',
            allowOutsideClick: false,
            confirmButtonText: 'OK',
        });
        </script>
        @endif --}}


        {{-- @if (Auth::check() && $booking)
          <div id="info-popup" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 md:p-8">
                    <div class="mb-4 text-sm font-light text-gray-500 dark:text-gray-400">
                        <h3 class="mb-3 text-2xl font-bold text-gray-900 dark:text-white">Privacy info</h3>
                        <h3 class="mb-5 text-lg font-normal text-red-500 dark:text-red-400">Your account has a {{ $booking }} Warning</h3>
                    </div>
                    <div class="justify-between items-center pt-0 space-y-4 sm:flex sm:space-y-0">
                        <a href="#" class="font-medium text-primary-600 dark:text-primary-500 hover:underline">Learn more about privacy</a>
                        <div class="items-center space-y-4 sm:space-x-4 sm:flex sm:space-y-0">
                            <button id="close-modal" type="button"  class="py-2 px-4 w-full text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 sm:w-auto hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 border border-slate-400 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Close</button>
                            <a  id="confirm-button" href="{{ route('home.history.show',Auth::id()) }}" class="py-2 px-4 w-full text-sm font-medium text-center text-white rounded-lg bg-primary-700 sm:w-auto hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-yellow-600 bg-yellow-500 hover:bg-yellow-600">Check History</a>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        @endif --}}
</main>

<script>


var startInput = document.getElementById('startInput');
var endInput = document.getElementById('endInput');

const date = new Date();
let currentDay= String(date.getDate()).padStart(2, '0');
let currentMonth = String(date.getMonth()+1).padStart(2,"0");
let currentYear = date.getFullYear();
let currentDate = `${currentYear}-${currentMonth}-${currentDay}`;
var isSelectingStart  = true;

var newArray = []; // Create an array to store objects

const olTimeList = document.getElementById('olTimeList');
function CalendarSchedulers(){
    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        allDaySlot: false,
        eventConstraint: 'businessHours', // E
        selectable: true,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: true,
            hour12: true
        },
        events: function (info, successCallback, failureCallback) {
            $.ajax({
                url: "{{ route('home.schedules.index') }}", // Replace with your route name or URL
                dataType: 'json',
                success: function (response) {
                    successCallback(response);
                },
                error: function (error) {
                    failureCallback(error);
                }
            });
        },
        eventDidMount: function (info) {
            var eventCount = info.event.extendedProps.eventCount;
            var date = info.date;
        },
      //  eventColor: '#378006',
        validRange: {
        start: currentDate,
    },
    selectable: true,
    select: function(info) {
       var startDate =  info.startStr;
       var endDate = info.endStr;
       //console.log(startDate)
       $.ajax({
        url: "{{ route('home.bookings.list') }}",
        method: 'GET',
        data:{startDate:startDate},
        success: function(data) {
           // console.log(data)
            var tableBody = $('#olTimeList').empty();
            var olRoomList = $('#olRoomList');
            var olFoodList = $('#olFoodList');

            var formattedDate = date.getFullYear() + "-" +
                                (date.getMonth() + 1).toString().padStart(2, '0') + "-" +
                                date.getDate().toString().padStart(2, '0');

            function DefaultData() {
                return [
                    {
                        'start_time': startDate + ' 08:00:00',
                        'end_time': startDate + ' 16:00:00',
                        'price':1000
                    },
                    {
                        'start_time': startDate + ' 18:00:00',
                        'end_time': startDate + ' 23:59:59',
                        'price':1200
                    },
                    {
                        'start_time': startDate + ' 18:00:00',
                        'end_time': startDate + ' 06:00:00',
                        'price':2000
                    }
                ];
            }
            var defaultBookings = DefaultData();


            var row = $('<li class="flex items-center gap-3 font-normal" style="text-align: center; ">');
                row.append('<p  class="font-bold" stye="font-weight: bold;">'+formatDateString(info.startStr)+'</p>')
                tableBody.append(row);


            defaultBookings = defaultBookings.filter(function (defaultBooking) {
                return !data.some(function (booking) {
                    return booking.start_time === defaultBooking.start_time && booking.end_time === defaultBooking.end_time;
                });
            });

            defaultBookings.forEach(function (defaultBooking,index) {
                var defaultStart = formatTime(defaultBooking.start_time.split(' ')[1]);
                var defaultEnd = formatTime(defaultBooking.end_time.split(' ')[1]);
                var mapa = data.find(function(m){
                    return m.start_time==defaultBooking.start_time
                })
                var row = $('<li class="flex items-center flex-row gap-3 font-normal">');
                if(mapa){
                    row.append('<span style="height:30px; width:30px; border:1px solid #777777; background:#d6d6d6; cursor: not-allowed;"></span>');
                    row.append('<label  class="font-bold" style="color:#777777; text-decoration: line-through " for="">' + formatTimeString(defaultStart) + ' ~ ' + formatTimeString(defaultEnd) + '</label>');
                }else{
                    row.append('<input value="' + defaultBooking.start_time + ' ' + defaultBooking.end_time + '" class="dateList" type="checkbox" id="time' + index + '" name="time" onclick="handleCheckbox(this,\'time' + index + '\')">');
                    row.append('<label  class="font-bold" >' + formatTimeString(defaultStart) + ' ~ ' + formatTimeString(defaultEnd) + '</label>');
                    row.append('<small  class="" >'+formatNumberWithCommas(defaultBooking.price)+'</small>');
                }
                $('#olRoomList').css('visible','visibility')
                $('#olListFood').css('visible','visibility')
                tableBody.append(row);

            });

            function formatTime(timeString) {
                const time = new Date('2023-11-08 ' + timeString);
                const hours = time.getHours().toString().padStart(2, '0');
                const minutes = time.getMinutes().toString().padStart(2, '0');
                return hours + ':' + minutes;
            }

            data.forEach(function (booking) {

                var formattedStart = formatTime(booking.start_time.split(' ')[1]);
                var formattedEnd = formatTime(booking.end_time.split(' ')[1]);

                if(formattedStart.toString()=='00:00'){
                    return
                }
                    var row = $('<li class="flex items-center gap-3 font-normal">');
                    row.append('<span style="height:30px; width:30px; border:1px solid #777777; background:#d6d6d6; cursor: not-allowed;"></span>');
                    row.append('<label class="font-bold" style="color:#777777; text-decoration: line-through " for="">' + formatTimeString(formattedStart) + ' ~ ' + formatTimeString(formattedEnd) + '</label>');
                tableBody.append(row);
            });

            olRoomList.css('visibility','visible')
            olFoodList.css('visibility','visible')
            if(data.length==2){
                tableBody.empty()
                var row = $('<li class="flex items-center gap-3 font-normal">');
                row.append('<p style="font-size:1.5rem;">Schedule has been fully booked, Please choose another.</p>');
                tableBody.append(row);
                olRoomList.css('visibility','hidden')
                olFoodList.css('visibility','hidden')
            }
            var tableBody = $('#bookListData').empty();;
            // data.forEach(function (booking) {
            //     var row = '<div class="text-xl" style="border-bottom: 5px solid white;padding:10px 30px;"><div><span class="bookClasses">Status</span> : '+booking.payment+'</div><div><span class="bookClasses">Purpose</span> : '+booking.title+'</div><div><span class="bookClasses">Book By </span> : '+booking.name+'</div><div><span class="bookClasses">Date</span> : '+formatDateTime(booking.start_time)+' ~ '+formatDateTime(booking.end_time)+'</div></div>';
            //     tableBody.append(row);
            // });
        },

        error:function(error){
            console.log(error)
        }
       })
    },
    nowIndicator: true,
    });
    calendar.render();

    function getEventCountForDate(date) {
            // You may need to adapt this logic based on your needs
            // For simplicity, this example assumes that events are fetched and stored globally
            // Adjust the logic based on your application's structure
            var events = getAllEvents(); // Replace with your actual function to get events
            var eventCount = 0;

            // Check the events for the specific date
            events.forEach(function (event) {
                var eventDate = new Date(event.start);
                if (eventDate.toISOString().split('T')[0] === date.toISOString().split('T')[0]) {
                    eventCount++;
                }
            });
            return eventCount;
    }
    function getAllEvents() {
        // You should implement this function to fetch all events
        // from your PHP endpoint or wherever they are stored
        // and return them as an array
        // For simplicity, we'll return an empty array here
        return [];
    }

}


CalendarSchedulers()

document.addEventListener("DOMContentLoaded", function () {
    var totalSum = 0;
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, "0"); // Add 1 to month since it's 0-based
    const currentDay = currentDate.getDate().toString().padStart(2, "0");
    const currentHours = currentDate.getHours().toString().padStart(2, "0");
    const currentMinutes = currentDate.getMinutes().toString().padStart(2, "0");
    const plusHour =(currentDate.getHours()+2).toString().padStart(2, "0");
    const minimumDateTime = `${currentYear}-${currentMonth}-${currentDay}`;
    const dateToday = `${currentYear}-${currentMonth}-${currentDay}`;
    const time = `${currentHours}:${currentMinutes}`;


 });


$('#formBtn').on('click',function(e){

    if (!$('input[name="time"]:checked').length) {
        Swal.fire({
            text: 'Schedule time, must be filled up!',
            icon: 'warning',
            allowOutsideClick: false,
            confirmButtonText: 'Continue',
        });
        return false;
    }

    if (!$('input[name="title"]:checked').length) {
        Swal.fire({
            text: 'Room Number, must be filled up!',
            icon: 'warning',
            allowOutsideClick: false,
            confirmButtonText: 'Continue',
        });
        return false;
    }


    if (!$('input[name="food[]"]:checked').length && !$('input[name="food"]:checked').length) {
        Swal.fire({
            text: 'Food Menu must be filled up!',
            icon: 'warning',
            allowOutsideClick: false,
            confirmButtonText: 'Continue',
        });
        return false;
    }

    var checkbox = document.querySelector('input[name="time"]:checked');
    // Get the value of the checked checkbox or return null if none is checked
    var checkedValue = checkbox ? checkbox.value : null;

    var checkboxTitle = document.querySelector('input[name="title"]:checked');

    // Get the value of the checked checkbox or return null if none is checked
    var checkboxTitleValue = checkboxTitle ? checkboxTitle.value : null;


    var foodListVar = foodList()

    var summaryTimeSub = $('#summaryTimeSub').text();

    var summaryRoomSub = $('#summaryRoomSub').text();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
        url: "{{ route('home.bookings.store') }}",
        method: 'POST',
        data:{
            startDate:checkedValue,
            startTitle:checkboxTitleValue,
            startFood:foodListVar,
            summaryTimeSub:summaryTimeSub,
            summaryRoomSub:summaryRoomSub
            },
        success: function(response) {
          console.log(response)
            if(response.error){
                Swal.fire({
                    text: response.error,
                    icon: 'warning',
                    allowOutsideClick: false,
                    confirmButtonText: 'Continue',
                })

            }else if(response.success){
                var redirectToPage = "{{ route('home.bookings.show', '') }}" + '/' + response.user.id;
                Swal.fire({
                    title: "Redirecting...",
                    text: "You will be redirected in a moment.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false,
                    }).then(() => {
                        window.location.href =  redirectToPage;
                });
            }else if(response.exist){
                console.log(response)
                var redirectToPage = "{{ route('home.bookings.show', '') }}" + '/' + response.user;
                Swal.fire({
                text: response.exist,
                icon: 'warning',
                allowOutsideClick: false,
                confirmButtonText: 'Go to schedule',
                cancelButtonText: 'Close',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = redirectToPage;
                }
            });
            }else if(response.moderator){
                Swal.fire({
                text: response.moderator,
                icon: 'error',
                allowOutsideClick: false,
                confirmButtonText: 'Okay',
                showCancelButton:false,
                cancelButtonText: 'Close',
                showCancelButton: true,
            });
            }else{
                CalendarSchedulers()
            }
        },
        error:function(error){
            console.log(error)
        }
   });
})

function formatTimeString(time){
    const today = new Date();
    const [hours, minutes, seconds] = time.split(':');
    const formattedTime = new Date(today);
    formattedTime.setHours(hours, minutes, seconds || 0, 0);
    return formattedTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
  };

function formatDateString(dateString) {
  const options = { year: 'numeric', month: 'long', day: 'numeric'};
  const date = new Date(dateString);
  const formattedDate = new Intl.DateTimeFormat('en-US', options).format(date);
  return formattedDate;
}

function formatDateTime(inputDateString) {
    var date = new Date(inputDateString);

    var options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
    };

    return date.toLocaleDateString('en-US', options);
}


function defaultWarningModal(){
    const modalEl = document.getElementById('info-popup');
    const privacyModal = new Modal(modalEl, {
        placement: 'center'
    });

    privacyModal.show();

    const closeModalEl = document.getElementById('close-modal');
    closeModalEl.addEventListener('click', function() {
        privacyModal.hide();
    });

    const acceptPrivacyEl = document.getElementById('confirm-button');
    acceptPrivacyEl.addEventListener('click', function() {
        privacyModal.hide();
    });
}

//defaultWarningModal()

</script>
<script>



function handleCheckbox(e,clickedId) {

    $('input[name="food"]').not('#' + clickedId).prop('checked', false);
    var dateTimes = e.value.split(' ');
    var smallElement = $(e).closest('li').find('small');
    var smallText = smallElement.text();

    var toggleSummary = document.getElementById('toggleSummary');
    toggleSummary.classList.add('active');
    var toggleSum = $('#toggleSum')
    toggleSum.addClass('active');
    toggleSum.text('Hide Summary');

    if(e.checked){
        $('#summarySchedule').text(formatDateString(dateTimes[0]))
        $('#summaryTime').text(formatTimeString(dateTimes[1])+' ~ '+formatTimeString(dateTimes[3]))
        $('#summaryTimeSub').text(smallText)
        updateTotalSum();
    }else{
        $('#summarySchedule').text('-------')
        $('#summaryTime').text('-------')
        $('#summaryTimeSub').text(0)
    }

    var checkboxes = document.getElementsByName('time');
    checkboxes.forEach(function(checkbox) {
        if (checkbox.id !== clickedId) {
        checkbox.checked = false;
        }
    });

    updateTotalSum();
}

function roomCheckbox(e,clickedId) {
    var smallElement = $(e).closest('li').find('small');

    var smallText = smallElement.text();

    var toggleSummary = document.getElementById('toggleSummary');
    toggleSummary.classList.add('active');
    var toggleSum = $('#toggleSum')
    toggleSum.addClass('active');
    toggleSum.text('Hide Summary');

    if(e.checked){
        $('#summaryRoom').text(capitalizeEachWord(e.value))
        $('#summaryRoomSub').text(smallText)
    }else{
        $('#summaryRoom').text('-------')
        $('#summaryRoomSub').text(0)
    }

    var checkboxes = document.getElementsByName('title');
    checkboxes.forEach(function(checkbox) {
        if (checkbox.id !== clickedId) {
        checkbox.checked = false;
        }
  });
  updateTotalSum();
}

function foodCheckbox(e,clickedId) {
   // console.log('clickedId:', clickedId);
    $('input[name="food"]').not('#' + clickedId).prop('checked', false);

    var toggleSummary = document.getElementById('toggleSummary');
    toggleSummary.classList.add('active');
    var toggleSum = $('#toggleSum')
    toggleSum.addClass('active');
    toggleSum.text('Hide Summary');

    var checkedFoodArray = $('input[name="food[]"]:checked').map(function() {
        return this.value;
    }).get();

    var checkedFoodPrices = $('input[name="food[]"]:checked').map(function() {
        return parseFloat($(this).next('label').find('small').text().replace(/,/g, '')) || 0;
    }).get();

    var total = checkedFoodPrices.reduce(function(acc, price) {
        return acc + price;
    }, 0);


    // Update the food list span
    $('#foodListSpan').text(capitalizeEachWord(checkedFoodArray.join(' , ')));

    // Update the subtotal span with formatted total
    $('#subtotalSpan').text(formatNumberWithCommas(total));

//   var checkboxes = document.getElementsByName('food');
//   checkboxes.forEach(function(checkbox) {
//     if (checkbox.id !== clickedId) {
//       checkbox.checked = false;
//     }
//   });


// Rest of your code...

    var checkboxesx = document.querySelector('#food-1');  // Updated this line

    if(clickedId==checkboxesx.id){
        var checkboxes = document.getElementsByName('food[]');
          checkboxes.forEach(function (checkbox) {
            if (checkbox.id !== clickedId) {
                checkbox.checked = false;
                $('#foodListSpan').text('-------');
                $('#subtotalSpan').text(0);
            }
        });
    }



  updateTotalSum();
}

function capitalizeEachWord(inputString) {
    return inputString.replace(/\b\w/g, function (match) {
        return match.toUpperCase();
    });
}

function formatNumberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


function foodList(){
    var checkedFoodArray = $('input[name="food[]"]:checked').map(function() {
            return this.value;
        }).get();

    var checkedFoodPrices = $('input[name="food[]"]:checked').map(function() {
            // Get the value of the next sibling <small> element
            return $(this).next('label').find('small').text();
        }).get();
    if(checkedFoodArray.length!=0 && checkedFoodPrices.length!=0){
        var FoodList = [checkedFoodArray,checkedFoodPrices]
    }else{
        var FoodList = ['none',0]
    }

    return FoodList
}

function updateTotalSum() {
    var summaryTimeSub = parseFloat($('#summaryTimeSub').text().replace(/,/g, '')) || 0;
    var summaryRoomSub = parseFloat($('#summaryRoomSub').text().replace(/,/g, '')) || 0;

    // Update the total sum
    totalSum = summaryTimeSub + summaryRoomSub;

    // Add the total from checked food prices
    var checkedFoodPrices = $('input[name="food[]"]:checked').map(function() {
        return parseFloat($(this).next('label').find('small').text().replace(/,/g, '')) || 0;
    }).get();

    totalSum += checkedFoodPrices.reduce(function(acc, price) {
        return acc + price;
    }, 0);

    // Display the updated total sum wherever needed
    $('#totalSummary').text(formatNumberWithCommas(totalSum));
}

function showSweetAlert(){
    Swal.fire({
        text: 'You need to login, before make a schedule!',
        icon: 'warning',
        allowOutsideClick: false,
        confirmButtonText: 'Yes, login me',
    }).then(() => {
        window.location.href =  '/login';
     });
    return false;
}

function toggleContainer() {
    var toggleSummary = document.getElementById('toggleSummary');
    toggleSummary.classList.toggle('active');
    var toggleSum = $('#toggleSum')
    if (toggleSum.hasClass('active')) {
        toggleSum.removeClass('active');
        toggleSum.text('Show Summary');
      } else {
        toggleSum.addClass('active');
        toggleSum.text('Hide Summary');
      }
  }
</script>

@endsection
