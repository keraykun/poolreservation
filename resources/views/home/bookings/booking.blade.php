@extends('home.layout')
@section('content')
<main>
<style>
#calendar {
  max-width: 700px;
  margin: 0 auto;
  border:1px solid rgb(14, 92, 123);
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

#scrollColors::-webkit-scrollbar {
  width: 12px; /* Adjust the width of the scrollbar */
}

#scrollColors::-webkit-scrollbar-thumb {
  background-color: #12476a !important ; /* Change the color of the thumb (the draggable part) */
}

#scrollColors::-webkit-scrollbar-track {
 margin-top: 35px;
 margin-bottom: 35px;
}


</style>

    {{-- @if (Auth::check()) --}}
        <section class="p-5 flex flex-row flex-wrap items-center justify-center w-full gap-5">
            <div class="max-w-sm w-[300px] border border-sky-700 drop-shadow-md ">
                <div class="py-5 bg-sky-700 text-2xl font-bold text-white text-center">
                    TIME
                </div>
                <div class="p-5" id="timeDiv">
                    <ol class="mb-3 p-5 flex gap-2 flex-col  text-gray-700 dark:text-gray-400 font-bold" id="olTimeList">
                        {{-- <li class="flex items-center gap-3 font-normal">
                            <input value="2023-07-12 8:00:00 16:00:00" class="dateList" type="checkbox" id="time1" name="time" onclick="handleCheckbox('time1')">
                            <label for="">8:00 AM ~ 4:00 PM</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input value="2023-07-12 18:00:00 23:59:59" class="dateList" type="checkbox" id="time2" name="time" onclick="handleCheckbox('time2')">
                            <label for="">6:00 PM ~ 11:59 PM</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input value="2023-07-12 18:00:00 6:00:00" class="dateList" type="checkbox" id="time3" name="time3" onclick="handleCheckbox('time3')">
                            <label for="">6:00 PM ~ 6:00 AM</label>
                        </li> --}}
                    </ol>
                    {{-- <a  href="{{ route('home.announcement.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-sm hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        View More</i>
                        <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a> --}}
                </div>
            </div>
            <div class="max-w-sm w-[300px] border border-sky-700 drop-shadow-md ">
                <div class="py-5 bg-sky-700 text-2xl font-bold text-white text-center">
                    ROOM
                </div>
                <div class="p-5">
                    <ol class="mb-3 p-5 flex gap-2 flex-col  text-gray-700 dark:text-gray-400 font-bold" id="olRoomList">
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="room1" name="room" onclick="roomCheckbox('room1')">
                            <label for="">Invidual Size</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="room2" name="room" onclick="roomCheckbox('room2')">
                            <label for="">Couple Size</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="room3" name="room" onclick="roomCheckbox('room3')">
                            <label for="">Family Size</label>
                        </li>
                    </ol>
                    {{-- <a  href="{{ route('home.announcement.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-sm hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        View More</i>
                        <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a> --}}
                </div>
            </div>
            <div class="max-w-sm w-[300px] border border-sky-700 drop-shadow-md ">
                <div class="py-5 bg-sky-700 text-2xl font-bold text-white text-center">
                    FOOD MENU
                </div>
                <div class="p-5" id="scrollColors" style="height: 200px;overflow-y:scroll;" id="olFoodList">
                    <ol class="mb-3 p-5 flex gap-2 flex-col  text-gray-700 dark:text-gray-400 font-bold">
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food1" name="food[]" onclick="foodCheckBox('food1')">
                            <label for="">Pork Lumpia</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food2" name="food[]" onclick="foodCheckBox('food2')">
                            <label for="">Inihaw Bangus</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food3" name="food[]" onclick="foodCheckBox('food3')">
                            <label for="">Sinigang Pork</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food4" name="food[]" onclick="foodCheckBox('food4')">
                            <label for="">Sinigang Pork</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food5" name="food[]" onclick="foodCheckBox('food5')">
                            <label for="">Sinigang Pork</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food6" name="food[]" onclick="foodCheckBox('food6')">
                            <label for="">Sinigang Pork</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food7" name="food[]" onclick="foodCheckBox('food7')">
                            <label for="">Sinigang Pork</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food8" name="food[]" onclick="foodCheckBox('food8')">
                            <label for="">Sinigang Pork</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food9" name="food[]" onclick="foodCheckBox('food9')">
                            <label for="">Sinigang Pork</label>
                        </li>
                        <li class="flex items-center gap-3 font-normal">
                            <input type="checkbox" id="food10" name="food[]" onclick="foodCheckBox('food10')">
                            <label for="">Sinigang Pork</label>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="max-w-sm w-[300px] border border-sky-700 drop-shadow-md ">
                <div class="h-40">
                    <div class="text-2xl font-bold flex items-center drop-shadow-lg justify-center h-full backdrop-brightness-[0.85] w-full text-white uppercase"><i class="fa-solid fa-landmark p-6 rounded-full text-blue-800 text-6xl bg-white"></i></div>
                </div>
                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"> Pool Party</h5>
                    <ol class="mb-3 p-5 list-disc text-gray-700 dark:text-gray-400 font-bold">
                        <li>sample 1</li>
                        <li>sample 2</li>
                        <li>sample 3</li>
                    </ol>
                    <button  href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-500  rounded-sm hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        View More
                    </button>
                </div>
            </div>
        </section>
        <section class="p-5 rounded-sm flex flex-row flex-wrap items-center justify-center w-full gap-5 bg-sky-300">
            <form action="" id="formCalendar" class="font-bold font-mono flex gap-3">
                <label for="">Date</label>
                <input type="date" name="startDate" id="startDate" class="py-1 px-3 rounded-md outline-none" placeholder="Start Date">
                <label for="">Select time</label>
                <select name="startTime" id="startTime" class="py-1 px-3 rounded-md outline-none">
                    <option disabled selected="selected"  value="8:00 16:00">--Select Time--</option>
                    @foreach ($schedules as $schedule)
                        <option value="{{ $schedule->start.' '.$schedule->end }}">{{ date('h:i:s a',strtotime($schedule->start)).' ~ '.date('h:i:s a',strtotime($schedule->end)) }}</option>
                    @endforeach
                </select>
                <label for="">Purpose</label>
                <select name="startTitle" id="startTitle" class="py-1 px-3 rounded-md outline-none">
                    <option disabled selected="selected"  value="8:00 16:00">--Select Purpose--</option>
                    <option value="Pool Party">Pool Party</option>
                    <option value="Overnight Party">Overnight Party</option>
                    <option value="Birthday">Birthday</option>
                    <option id="othersSelect">Others</option>
                </select>
                <select name="startCategory" id="startCategory" class="py-1 px-3 rounded-md outline-none">
                    <option disabled selected="selected"  value="8:00 16:00">--Select Food--</option>
                    <option value="Packge Foods">Package Foods ( ₱ 500 )</option>
                    <option value="Package Foods with Drinks">Package Foods with Drinks ( ₱ 1,000 )</option>
                    <option value="none">None</option>
                </select>
                @if (Auth::check())
                <button class="bg-green-500 py-1 px-4 cursor-pointer rounded-md text-white text-md hover:bg-green-600" type="button" id="formBtn">Create <i class="fa fa-clock"></i></button>
                @else
                <button class="bg-green-500 py-1 px-4 cursor-pointer rounded-md text-white text-md hover:bg-green-600" type="button" data-modal-target="popup-modal" data-modal-toggle="popup-modal">Create <i class="fa fa-clock"></i></button>

        <!--modal-->
        <div id="popup-modal"  data-modal-backdrop="static" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">You need to login first before you schedule</h3>
                        <a data-modal-hide="popup-modal" href="{{ route('guest.login') }}" class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Login, me
                        </a>
                        <button data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
         <!--end modal-->


        @endif
        </form>

        @if (Auth::check() && $booking)
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
        @endif

        </section>
        <section class="p-5 rounded-sm flex  w-full gap-5">
            <div class="w-full" id="calendar">
                <span class="flex justify-around my-1">
                    <span class="flex justify-center items-center">
                        <span style="width: 15px; height: 15px;border: 3px solid rgba(12, 178, 228, 1); margin-right:10px;"></span>
                        <span>Available</span>
                    </span>
                    <span class="flex justify-center items-center">
                        <span style="width: 15px; height: 15px;background-color: rgba(12, 178, 228, 1); margin-right:10px;"></span>
                        <span>Not Available / Closed</span>
                    </span>
                </span>
            </div>
            <div style="width:100%;" id="bookListData">

            </div>
        </section>
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
        eventColor: '#378006',
        validRange: {
        start: currentDate,
    },
    selectable: true,
    select: function(info) {
       var startDate =  info.startStr;
       var endDate = info.endStr;
       $.ajax({
        url: "{{ route('home.bookings.list') }}",
        method: 'GET',
        data:{startDate:startDate},
        // success: function(data) {
        //     var formattedDate = date.getFullYear() + "-" +
        //                     (date.getMonth() + 1).toString().padStart(2, '0') + "-" +
        //                     date.getDate().toString().padStart(2, '0');

        //         var tableBody = $('#olTimeList').empty();
        //         if (data.length === 0) {
        //             // Append default data when the received data is empty
        //             var color = 'blue';
        //             data = DefaultData();
        //         }else{
        //             var color = 'red';
        //         }

        //         function DefaultData() {
        //             return [
        //                 {
        //                     'start_time': formattedDate + ' 08:00:00',
        //                     'end_time': formattedDate + ' 16:00:00'
        //                 },
        //                 {
        //                     'start_time': formattedDate + ' 18:00:00',
        //                     'end_time': formattedDate + ' 23:59:59'
        //                 },
        //                 {
        //                     'start_time': formattedDate + ' 18:00:00',
        //                     'end_time': formattedDate + ' 6:00:00'
        //                 }
        //             ];
        //         }
        //         data.forEach(function(booking) {
        //             var formattedStart = formatTime(booking.start_time.split(' ')[1]);
        //             var formattedEnd = formatTime(booking.end_time.split(' ')[1]);

        //             var row = $('<li class="flex items-center gap-3 font-normal">');
        //             row.append('<input value="' + booking.start_time + ' ' + booking.end_time + '" class="dateList" type="checkbox" id="time' + Math.floor(Math.random() * 1000) + '" name="time' + Math.floor(Math.random() * 1000) + '" onclick="handleCheckbox(\'time' + Math.floor(Math.random() * 1000) + '\')">');
        //             row.append('<label style="color:' + color + '" for="">' + formattedStart + ' ~ ' + formattedEnd + '</label>');

        //             tableBody.append(row);
        //         });



        //         function formatTime(timeString) {
        //             const time = new Date('2023-12-08 ' + timeString);
        //             const hours = time.getHours().toString().padStart(2, '0');
        //             const minutes = time.getMinutes().toString().padStart(2, '0');
        //             return hours + ':' + minutes;
        //         }

        // },
        success: function(data) {
            var tableBody = $('#olTimeList').empty();

            var formattedDate = date.getFullYear() + "-" +
                                (date.getMonth() + 1).toString().padStart(2, '0') + "-" +
                                date.getDate().toString().padStart(2, '0');

            function DefaultData() {
                return [
                    {
                        'start_time': startDate + ' 08:00:00',
                        'end_time': startDate + ' 16:00:00'
                    },
                    {
                        'start_time': startDate + ' 18:00:00',
                        'end_time': startDate + ' 23:59:59'
                    },
                    {
                        'start_time': startDate + ' 18:00:00',
                        'end_time': startDate + ' 06:00:00'
                    }
                ];
            }

            var defaultBookings = DefaultData();

            // Filter out default bookings that already exist in the received data
            defaultBookings = defaultBookings.filter(function (defaultBooking) {
                return !data.some(function (booking) {
                    return booking.start_time === defaultBooking.start_time && booking.end_time === defaultBooking.end_time;
                });
            });

            defaultBookings.forEach(function (defaultBooking) {
                var defaultStart = formatTime(defaultBooking.start_time.split(' ')[1]);
                var defaultEnd = formatTime(defaultBooking.end_time.split(' ')[1]);

                var row = $('<li class="flex items-center gap-3 font-normal">');
                row.append('<input value="' + defaultBooking.start_time + ' ' + defaultBooking.end_time + '" class="dateList" type="checkbox" id="time' + Math.floor(Math.random() * 1000) + '" name="time' + Math.floor(Math.random() * 1000) + '" onclick="handleCheckbox(\'time' + Math.floor(Math.random() * 1000) + '\')">');
                row.append('<label style="color:blue" for="">' + defaultStart + ' ~ ' + defaultEnd + '</label>');

                tableBody.append(row);
            });

            function formatTime(timeString) {
                const time = new Date('2023-12-08 ' + timeString);
                const hours = time.getHours().toString().padStart(2, '0');
                const minutes = time.getMinutes().toString().padStart(2, '0');
                return hours + ':' + minutes;
            }

            data.forEach(function (booking) {
                var formattedStart = formatTime(booking.start_time.split(' ')[1]);
                var formattedEnd = formatTime(booking.end_time.split(' ')[1]);

                var row = $('<li class="flex items-center gap-3 font-normal">');
                row.append('<input value="' + booking.start_time + ' ' + booking.end_time + '" class="dateList" type="checkbox" id="time' + Math.floor(Math.random() * 1000) + '" name="time' + Math.floor(Math.random() * 1000) + '" onclick="handleCheckbox(\'time' + Math.floor(Math.random() * 1000) + '\')">');
                row.append('<label style="color:red" for="">' + formattedStart + ' ~ ' + formattedEnd + '</label>');
                tableBody.append(row);
            });

            if(data.length==2){
                tableBody.empty()
                var row = $('<li class="flex items-center gap-3 font-normal">');
                row.append('<p>Schedule has been fully booked, Please choose another.</p>');
                tableBody.append(row);
            }
        },

        error:function(error){
            console.log(error)
        }
       })
    },
        nowIndicator: true,
    });
    calendar.render();
}


CalendarSchedulers()

document.addEventListener("DOMContentLoaded", function () {
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

    document.getElementById("startDate").value = dateToday;
    // document.getElementById("time").value = time;
    document.getElementById("startDate").min = minimumDateTime;

 });


$('#formBtn').on('click',function(e){

    e.preventDefault();
    if($('#startTitle').val()===null){
        Swal.fire({
            title: 'Error!',
            text: 'Invalid Purpose must be fill up!',
            icon: 'error',
            allowOutsideClick: false,
            confirmButtonText: 'Continue',
        })
        return false;
    }

    if($('#startTime').val()===null){
        Swal.fire({
            title: 'Error!',
            text: 'Invalid Time must be fill up!',
            icon: 'error',
            allowOutsideClick: false,
            confirmButtonText: 'Continue',
        })
        return false;
    }

    if($('#startCategory').val()===null){
        Swal.fire({
            title: 'Error!',
            text: 'Invalid Category be fill up!',
            icon: 'error',
            allowOutsideClick: false,
            confirmButtonText: 'Continue',
        })
        return false;
    }


    let currentDate = new Date($('#startDate').val())
    var outputDate = currentDate.toLocaleString('en-US', {
        timeZone: 'Asia/Manila',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour12: false
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
        url: "{{ route('home.bookings.store') }}",
        method: 'POST',
        data:{
            startDate:outputDate,
            startCategory:$('#startCategory').val(),
            startTime:$('#startTime').val(),
            startTitle:$('#startTitle').val(),
            },
        success: function(response) {
            if(response.error){
                Swal.fire({
                    title: 'Error!',
                    text: response.error,
                    icon: 'error',
                    allowOutsideClick: false,
                    confirmButtonText: 'Continue',
                })
                //CalendarSchedulers()
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

            }else{
              //  console.log('something error')
                CalendarSchedulers()
            }
        },
        error:function(error){
            console.log(error)
        }
    });
})

function formatDateString(dateString) {
  const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
  const date = new Date(dateString);
  const formattedDate = new Intl.DateTimeFormat('en-US', options).format(date);
  return formattedDate;
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
function handleCheckbox(clickedId) {
  // Get all checkboxes with the name "time"
  var checkboxes = document.getElementsByName('time');
  // Loop through all checkboxes and uncheck them, except the one that was clicked
  checkboxes.forEach(function(checkbox) {
    if (checkbox.id !== clickedId) {
      checkbox.checked = false;
    }
  });
}
function roomCheckbox(clickedId) {
  // Get all checkboxes with the name "time"
  var checkboxes = document.getElementsByName('room');
  // Loop through all checkboxes and uncheck them, except the one that was clicked
  checkboxes.forEach(function(checkbox) {
    if (checkbox.id !== clickedId) {
      checkbox.checked = false;
    }
  });
}
</script>

@endsection
