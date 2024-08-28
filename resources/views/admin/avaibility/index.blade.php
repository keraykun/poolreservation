@extends('admin.layouts')
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
    <section class="px-5 flex flex-row items-start justify-start w-full gap-5 relative">
        <div class="flex-col flex w-full gap-5">

        <!-- Modal -->
            <div class="modal fade bd-example-modal-lg" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="olHeadList" style="margin: 10px;">

                        </div>
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">TIME SCHEDULE</th>
                                <th scope="col">STATUS</th>
                                <th scope="col"></th>
                                <th scope="col">ACTION</th>

                              </tr>
                            </thead>
                            <tbody id="olTimeList">

                            </tbody>
                          </table>
                        {{-- <ol class="mb-3 px-5 flex gap-2 flex-col  text-gray-700 dark:text-gray-400 font-bold" id="olTimeList">
                            <li class="flex items-center gap-3 font-normal">
                                <p class="text-lg font-bold text-slate-700">Please select your booking schedule on the above calendar</p>
                            </li>
                        </ol> --}}
                    </div>
                    <div class="modal-footer">
                    <button type="button" id="formBtn" class="btn bg-sky-700 hover:bg-sky-600 text-white">Save changes</button>
                    </div>
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
function closeModalBar(){
    $('#exampleModal').modal('hide')
}
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
        $('#exampleModal').modal('show')

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
            var headList = $('#olHeadList').empty();


            var formattedDate = date.getFullYear() + "-" +
                                (date.getMonth() + 1).toString().padStart(2, '0') + "-" +
                                date.getDate().toString().padStart(2, '0');

            function DefaultData() {
                return [
                    {
                        'start_time': startDate + ' 08:00:00',
                        'end_time': startDate + ' 16:00:00',
                        // 'price':1000
                    },
                    {
                        'start_time': startDate + ' 18:00:00',
                        'end_time': startDate + ' 23:59:59',
                        // 'price':1200
                    },
                    {
                        'start_time': startDate + ' 18:00:00',
                        'end_time': startDate + ' 06:00:00',
                        // 'price':2000
                    }
                ];
            }
            var defaultBookings = DefaultData();

            var headListBody = $('<div>');  // Initialize headListBody as a new div

            headListBody.append('<p class="font-bold" style="font-weight: bold;">' + formatDateString(info.startStr) + '</p>');
            headList.append(headListBody);

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
                var row = $('<tr>');
                if (mapa) {
                    // row.append('<td><span style="height:30px; width:30px; border:1px solid #777777; background:#d6d6d6; cursor: not-allowed;"></span></td>');
                    row.append('<td><span class="font-bold" style="color:#777777; text-decoration: line-through " for="">' + formatTimeString(defaultStart) + ' ~ ' + formatTimeString(defaultEnd) + '</span></td>');
                    row.append('<td>Not Available</td>');
                    row.append('<td>--------</td>');
                    row.append('<td>--------</td>');
                } else {
                    // row.append('<td><input value="' + defaultBooking.start_time + ' ' + defaultBooking.end_time + '" class="dateList" type="checkbox" id="time' + index + '" name="time"  onclick="handleCheckbox(this,\'time' + index + '\')"></td>');
                    row.append('<td><label class="font-bold">' + formatTimeString(defaultStart) + ' ~ ' + formatTimeString(defaultEnd) + '</label></td>');
                    // row.append('<td><small style="color:green;">Open</small></td>');
                    row.append('<td style="color:green;">Available</td>');
                    row.append('<td></td>');
                    row.append('<td><input value="' + defaultBooking.start_time + ' ' + defaultBooking.end_time + '" class="dateList" type="checkbox" id="time' + index + '" name="time"  onclick="handleCheckbox(this,\'time' + index + '\')"></td>');
                }

                $('#olTimeList').append(row);
                $('#olRoomList').css('visibility', 'visible');
                $('#olListFood').css('visibility', 'visible');
                tableBody.append(row);
                // var row = $('<li class="flex items-center flex-row gap-3 font-normal">');
                // if(mapa){
                //     row.append('<span style="height:30px; width:30px; border:1px solid #777777; background:#d6d6d6; cursor: not-allowed;"></span>');
                //     row.append('<label  class="font-bold" style="color:#777777; text-decoration: line-through " for="">' + formatTimeString(defaultStart) + ' ~ ' + formatTimeString(defaultEnd) + '</label>');
                // }else{
                //     row.append('<input value="' + defaultBooking.start_time + ' ' + defaultBooking.end_time + '" class="dateList" type="checkbox" id="time' + index + '" name="time"  onclick="handleCheckbox(this,\'time' + index + '\')">');
                //     row.append('<label  class="font-bold" >' + formatTimeString(defaultStart) + ' ~ ' + formatTimeString(defaultEnd) + '</label>');
                //     row.append('<small  class="" style="color:green;">Open</small>');
                // }
                // $('#olRoomList').css('visible','visibility')
                // $('#olListFood').css('visible','visibility')
                // tableBody.append(row);

            });

            function formatTime(timeString) {
                const time = new Date('2023-11-08 ' + timeString);
                const hours = time.getHours().toString().padStart(2, '0');
                const minutes = time.getMinutes().toString().padStart(2, '0');
                return hours + ':' + minutes;
            }

            data.forEach(function (booking) {

                var book = booking.barcode.toString()
                var formattedStart = formatTime(booking.start_time.split(' ')[1]);
                var formattedEnd = formatTime(booking.end_time.split(' ')[1]);

                if(formattedStart.toString()=='00:00'){
                    return
                }
                var redirectToPage = "{{ route('admin.availity.show', '') }}" + '/' + booking.user_id;
                var row = $('<tr>');
                // row.append('<td><span style="height:30px; width:30px; border:1px solid #777777; background:#d6d6d6; cursor: not-allowed;"></span></td>');
                row.append('<td><label class="font-bold" style="color:#777777; text-decoration: line-through " for="">' + formatTimeString(formattedStart) + ' ~ ' + formatTimeString(formattedEnd) + '</label></td>');
                // row.append('<td><small style="color:white;cursor:pointer; background:red; padding:1px 3px; border-radius:5px;" data-user="'+booking.user_id+'" id="'+book+'" onclick="removeBooking(this)">Remove</small></td>');
                if(booking.payment=='pending'){
                    row.append('<td style="color:red;">Pending</td>');
                    row.append('<td style="color:#20a7db;"><a href="'+redirectToPage+'">View Details</a></td>');
                    row.append('<td><small  class="" style="color:white;cursor:pointer; background:red; padding:5px; border-radius:10px;" data-user="'+booking.user_id+'" id="'+book+'"  onclick="removeBooking(this)" >CANCEL BOOKING</small></td>');
                }else if(booking.payment=='paid'){
                    row.append('<td style="color:red;">Paid</td>');
                    row.append('<td style="color:#20a7db;"><a href="'+redirectToPage+'">View Details</a></td>');
                    row.append('<td><small  class="" style="color:white;cursor:pointer; background:red; padding:5px; border-radius:10px;" data-user="'+booking.user_id+'" id="'+book+'"  onclick="removeBooking(this)" >CANCEL BOOKING</small></td>');
                }else if(booking.payment=='done'){
                    row.append('<td style="color:red;">Done</td>');
                    row.append('<td>--------</td>');
                    row.append('<td>--------</td>');
                }else if(booking.payment=='reserve'){
                    row.append('<td style="color:green;">Reserve</td>');
                    row.append('<td style="color:#20a7db;"><a href="'+redirectToPage+'">View Details</a></td>');
                    row.append('<td><small  class="" style="color:white;cursor:pointer; background:red; padding:5px; border-radius:10px;" data-user="'+booking.user_id+'" id="'+book+'"  onclick="removeBooking(this)" >CANCEL BOOKING</small></td>');
                }

                tableBody.append(row);
                    // var row = $('<li class="flex items-center gap-3 font-normal">');
                    // row.append('<span style="height:30px; width:30px; border:1px solid #777777; background:#d6d6d6; cursor: not-allowed;"></span>');
                    // row.append('<label class="font-bold" style="color:#777777; text-decoration: line-through " for="">' + formatTimeString(formattedStart) + ' ~ ' + formatTimeString(formattedEnd) + '</label>');
                    // row.append('<small  class="" style="color:white;cursor:pointer; background:red; padding:1px 3px; border-radius:5px;" data-user="'+booking.user_id+'" id="'+book+'"  onclick="removeBooking(this)" >Remove</small>');
                    // tableBody.append(row);

            });

            olRoomList.css('visibility','visible')
            olFoodList.css('visibility','visible')
            // if(data.length==2){
            //     tableBody.empty()
            //     var row = $('<li class="flex items-center gap-3 font-normal">');
            //     row.append('<p style="font-size:1.5rem;">Schedule has been fully booked, Please choose another.</p>');
            //     tableBody.append(row);
            //     olRoomList.css('visibility','hidden')
            //     olFoodList.css('visibility','hidden')
            // }




            // var tableBody = $('#bookListData').empty();;
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

function removeBooking(barcode){
    var id = $(barcode).attr('id')
    var userID = $(barcode).data("user");

    Swal.fire({
        text: 'Are you sure you wan\'t remove this? ',
        icon: 'warning',
        allowOutsideClick: false,
        confirmButtonText: 'Yes, Cancel it',
        cancelButtonText: 'Close',
        confirmButtonColor: 'red',
        showCancelButton: true,
    }).then((result) => {
        if(result.isConfirmed){
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.availity.destroy', ['availity' => ':id']) }}".replace(':id', id),
                method:'DELETE',
                data:{user:userID},
                success: function(response) {
                    Swal.fire({
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'Continue',
                     });
                    $('#exampleModal').modal('hide')
                    CalendarSchedulers()
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            })
        }
    });
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



    var checkbox = document.querySelector('input[name="time"]:checked');
    // Get the value of the checked checkbox or return null if none is checked
    var checkedValue = checkbox ? checkbox.value : null;


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
        url: "{{ route('admin.availity.store') }}",
        method: 'POST',
        data:{
            startDate:checkedValue,
        },
        success: function(response) {
            Swal.fire({
                text: response.success,
                icon: 'success',
                allowOutsideClick: false,
                confirmButtonText: 'Continue',
            })
            $('#exampleModal').modal('hide')
            CalendarSchedulers()
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


</script>
<script>




function capitalizeEachWord(inputString) {
    return inputString.replace(/\b\w/g, function (match) {
        return match.toUpperCase();
    });
}

function formatNumberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

  function handleCheckbox(e,clickedId) {

$('input[name="food"]').not('#' + clickedId).prop('checked', false);

var checkboxes = document.getElementsByName('time');
checkboxes.forEach(function(checkbox) {
    if (checkbox.id !== clickedId) {
    checkbox.checked = false;
    }
});


}
</script>

@endsection
