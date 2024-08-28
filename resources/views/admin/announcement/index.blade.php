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

            <div class="w-full">
                <div class="w-full" id="calendar">
                </div>
            </div>
        </div>

    </section>

    <!-- Bootstrap Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Event Details</h5>

            </div>
            <div class="modal-body" id="eventDetails">
                <!-- Event details will be displayed here -->
            </div>
            <div class="modal-footer flex justify-between">
                <button type="button" id="deleteButton" onclick="deleteModal()" class="btn bg-red-500 hover:bg-red-600 text-white" data-dismiss="modal"><i class="fa fa-trash"></i></button>
              <div>
                <button type="button" id="editUpdateButton" onclick="editEventModal()" class="btn bg-sky-500 hover:bg-sky-600 text-white" data-dismiss="modal">Edit</button>
                <button type="button" onclick="closeEventModal()" class="btn bg-slate-500 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="eventModalEdit" tabindex="-1" role="dialog" aria-labelledby="eventModalEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalEditLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="eventDetailsEdit">
                <!-- User data and editable form will be displayed here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="closeEventModal()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="eventModalAdd" tabindex="-1" role="dialog" aria-labelledby="eventModalAddLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalAddLabel">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="eventDetailsAdd">
                <!-- Your form to add a new event goes here -->
                <form id="addEventForm">
                    <div class="form-group">
                        <label for="addTitleInput">Title:</label>
                        <input type="text" class="form-control" id="addTitleInput" placeholder="Enter title">
                    </div>
                    <div class="form-group">
                        <label for="addDescriptionInput">Description:</label>
                        <textarea class="form-control" id="addDescriptionInput" placeholder="Enter description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="addStartDateInput">Event Date:</label>
                        <input readonly type="date" id="addEventDate" class="form-control">
                    </div>
                    <!-- Add more input fields for other properties -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-sky-500 hover:bg-sky-600 text-white"  onclick="saveNewEvent()">Add Event</button>
                <button type="button" onclick="closeEventModal()" class="btn bg-slate-500 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</main>

<script>

function saveNewEvent() {

    var title = $('#addTitleInput').val();
    var description = $('#addDescriptionInput').val();
    var eventDate = $('#addEventDate').val();

    if (!title || !description) {
        Swal.fire({
            icon: 'warning',
            allowOutsideClick:false,
            title: 'Oops...',
            text: 'Title and description cannot be empty!',
        });
        return false;
    }

    var eventData = {
        title: title,
        description: description,
        eventDate: eventDate
    };

    $.ajax({
        type: 'POST',
        url: "{{ route('admin.announcement.store') }}",
        data: eventData,
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(response) {
            $('#addTitleInput').val('');
            $('#addDescriptionInput').val('');
            $('#addEventDate').val('');
            CalendarSchedulers()
            Swal.fire({
                icon: 'success',
                title: 'success',
                text: response,
            });

        },
        error: function(error) {
            console.error('Error sending data to the server:', error);
        },
        complete: function() {
            $('#eventModalAdd').modal('hide');
        }
    });
}

function deleteModal() {
    var primaryID = $('#editDescription').data('id');

    // Display SweetAlert confirmation dialogue
    Swal.fire({
        title: 'Confirmation',
        text: 'Are you sure you want to delete this event?',
        icon: 'warning',
        showCancelButton: true,
        allowOutsideClick: false ,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, proceed with the delete
            $.ajax({
                url: "{{ route('admin.announcement.destroy', ['announcement' => ':announcement']) }}".replace(':announcement', primaryID),
                type: 'DELETE',
                dataType: 'json',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    CalendarSchedulers()
                    Swal.fire({
                        icon: 'warning',
                        title: 'Deleted Successful!',
                        text: response,
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX Error:", jqXHR.status, textStatus, errorThrown);

                },
                complete: function() {
                    $('#editUpdateButton').css('visibility','visible');
                    $('#eventModal').modal('hide');
                }
            })
        }
    });
}

function editEventModal() {
    $('#editUpdateButton').css('visibility', 'hidden');

    var title = $('#editTitle').text();
    var description = $('#editDescription').text();
    var startDateString = $('#editStartDate').text().replace('Event Date ', '');
    var primaryID = $('#editDescription').data('id');

    // Parse the date string to a Date object
    var startDate = new Date(startDateString);

    // Get the timezone offset in minutes
    var timezoneOffset = startDate.getTimezoneOffset();

    // Adjust the startDate to the local time zone
    startDate.setMinutes(startDate.getMinutes() - timezoneOffset);

    // Format startDate to be in "YYYY-MM-DD" format
    var formattedStartDate = startDate.toISOString().split('T')[0];

    var modalContent = '<form id="editEventForm">';
    modalContent += '<div class="form-group">';
    modalContent += '<label for="editTitleInput">Title:</label>';
    modalContent += '<input type="text" class="form-control" id="editTitleInput" value="' + title + '">';
    modalContent += '<input type="hidden" class="form-control" id="primaryIdInput" value="' + primaryID + '">';
    modalContent += '</div>';
    modalContent += '<div class="form-group">';
    modalContent += '<label for="editDescriptionInput">Description:</label>';
    modalContent += '<textarea class="form-control" id="editDescriptionInput">' + description + '</textarea>';
    modalContent += '</div>';
    modalContent += '<div class="form-group">';
    modalContent += '<label for="editStartDateInput">Event Date</label>';
    modalContent += '<input type="date" class="form-control" id="editStartDateInput" value="' + formattedStartDate + '">';
    modalContent += '</div>';
    // Add more input fields for other properties

    // Update the "Edit" button to "Update" and change its functionality
    modalContent += '<button type="button" onclick="updateEvent()" class="btn bg-sky-700 hover:bg-sky-600 text-white">Update</button>';
    modalContent += '</form>';

    // Populate the modal body with the content
    $('#eventDetails').html(modalContent);

    // Show the Bootstrap modal
    $('#eventModal').modal('show');
}

function updateEvent() {
    // Retrieve updated data from the form
    var eventId = $('#primaryIdInput').val(); // Replace this with the actual event ID

    var updatedData = {
        id: eventId,
        title: $('#editTitleInput').val(),
        description: $('#editDescriptionInput').val(),
        startDate: $('#editStartDateInput').val(),

    };

    $.ajax({
        url: "{{ route('admin.announcement.update', ['announcement' => ':announcement']) }}".replace(':announcement', eventId),
        type: 'PATCH',
        data: updatedData,
        dataType: 'json',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        success: function(response) {
            CalendarSchedulers()
            Swal.fire({
                icon: 'success',
                title: 'Update Successful!',
                text: response,
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error:", jqXHR.status, textStatus, errorThrown);

        },
        complete: function() {
            $('#editUpdateButton').css('visibility','visible');
            $('#eventModal').modal('hide');
        }
    })


}

function closeModalBar(){
    $('#exampleModal').modal('hide')

}

function CalendarSchedulers() {
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        events: function (info, successCallback, failureCallback) {
            $.ajax({
                url: "{{ route('admin.announcement.list') }}",
                dataType: 'json',
                success: function (response) {
                    //console.log("AJAX Success:", response);
                    successCallback(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                   // console.log("AJAX Error:", jqXHR.status, textStatus, errorThrown);
                }
            });
        },
        selectable: true,
        select: function (info) {
            $('#addEventDate').val(info.startStr)
            $('#eventModalAdd').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#eventModalAdd').modal('show');
            $('#addStartDateInput').val(info.start.toISOString().split('T')[0]);
        },
        eventClick: function (info) {
            showEventDetails(info.event);
        },
    });

    calendar.render();


    function showEventDetails(event) {


        // Build HTML content for modal
        var modalContent = '<h5 id="editTitle">' + event.title + '</h5>';

        // Check if extendedProps exists and has data
        if (event.extendedProps) {
            // Include extendedProps data in modal content
            modalContent += '<p data-id="'+event.extendedProps.publicId+'" id="editDescription">' +event.extendedProps.description+ '</p>';
            modalContent += '<hr style="border-color: black; margin:15px 0px;">';
            modalContent += '<p id="editStartDate">Event Date: ' +event.startStr + '</p>';
            // Add more properties as needed
        }

        // Populate the modal with event details
        $('#eventDetails').html(modalContent);
        $('#eventModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        // Show the Bootstrap modal
        $('#eventModal').modal('show');
    }
}

CalendarSchedulers()

function closeEventModal() {
    // You can add additional logic here if needed
    $('#eventModalAdd').modal('hide')
    $('#eventModal').modal('hide'); // Manually hide the modal
    $('#editUpdateButton').css('visibility','visible');
}

</script>
@endsection
