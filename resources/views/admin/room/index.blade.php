@extends('admin.layouts')
@section('content')
<div class="container">
    <div class="row">
        <div class="my-3">
            <form method="GET">
                <div class="relative">
                    <input type="search" id="default-search" name="search" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
        </div>
        <div class="card mb-4">
               <div class="card-body">
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
                <button type="button" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#addRoom" class="btn-sm btn bg-green-700 hover:bg-green-800 text-white rounded-md shadow-md" href="">NEW ROOM</button>

                <!-- Modal -->
                <div class="modal fade" id="addRoom" tabindex="-1" role="dialog" aria-labelledby="addRoomModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="addRoomModalLabel"></h5>
                        <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Room Name</label>
                                <input type="text" id="roomName" class="form-control"  aria-describedby="emailHelp">

                            </div>
                            <div class="form-group">
                                <label for="exampleFood">Room Price</label>
                                <input type="text" id="roomPrice" class="form-control" aria-describedby="emailHelp">

                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn bg-slate-700 hover:bg-slate-800 text-white rounded-md shadow-md" data-dismiss="modal">Close</button>
                        <button id="roomBtn" type="button" class="btn btn-sm btn bg-green-700 hover:bg-green-800 text-white rounded-md shadow-md">Save changes</button>
                        </div>
                    </div>
                    </div>
                </div>
                 <!-- end Modal -->

                  <!--Edit Modal -->
                <div class="modal fade" id="editRoom" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="editRoomModalLabel"></h5>

                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Room Name</label>
                                <input type="text" id="editRoomName" class="form-control" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="exampleRoom">Room Price</label>
                                <input type="text" id="editRoomPrice" class="form-control" aria-describedby="emailHelp">
                            </div>
                            <input type="hidden" id="editID" class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="closeRoomBtn" class="btn btn-sm btn bg-slate-700 hover:bg-slate-800 text-white rounded-md shadow-md" data-dismiss="modal">Close</button>
                        <button id="updateRoomBtn"  type="button" class="btn btn-sm btn bg-green-700 hover:bg-green-800 text-white rounded-md shadow-md">Update changes</button>
                        </div>
                    </div>
                    </div>
                </div>
                 <!-- end Modal -->

            </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Room name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody id="roomTables">

                        </tbody>
                      </table>
                      <div class="mt-4">
                        {{-- {{ $users->withQueryString()->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>
<script>
 roomTable()

function roomTable(){

    $.ajax({
        url: "{{ route('admin.room.list') }}",
        method: 'GET',
        success: function(response) {
            // Append the retrieved data to the table body
            $('#roomTables').html(response);
        },
        error: function(error) {
            console.error('Error fetching data: ', error);
        }
    });
}

function editRoom(id) {

    $('#editRoom').modal({
        backdrop: 'static',
        keyboard: false
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ route('admin.room.edit', ['room' => ':id']) }}".replace(':id', id),
        method: 'GET',
        success: function (response) {
            $('#editRoom').modal('show')
            $('#editRoomName').val(response.name)
            $('#editRoomPrice').val(response.price)
            $('#editID').val(response.id)

        },
        error: function (error) {
            console.log(error);
        }
    });
}

function deleteRoom(id) {
    Swal.fire({
    text: 'Are you sure you want to remove?',
    icon: 'warning',
    confirmButtonText: 'Yes, Delete it',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, Delete it'
    }).then((result) => {
        // This block will be executed after the user clicks the "Close" button
        if (result.isConfirmed) {
                // Set up CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.room.destroy', ['room' => ':id']) }}".replace(':id', id),
            method: 'DELETE',
            success: function (response) {

                Swal.fire({
                    text: response.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Close'
                });

                roomTable()
            },
            error: function (error) {
                console.log(error);
            }
        });

        }
    });

}


$('#roomBtn').on('click',function(){

   var roomName = $('#roomName').val()
   var roomPrice = $('#roomPrice').val()

   if(roomName==''){
    Swal.fire({
        text: 'Room field must be required !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
     return false;
   }

   if(roomPrice==''){
    Swal.fire({
        text: 'Room price must be required !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
     return false;
   }

   if (!/^\d+$/.test(roomPrice)) {
    Swal.fire({
        text: 'Room price must be number !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
    return false;
   }

   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
        url: "{{ route('admin.room.store') }}",
        method: 'POST',
        data:{
          roomName:roomName,
          roomPrice:roomPrice,
        },
        success: function(response) {

            Swal.fire({
                text: response.message,
                icon: 'success',
                showCancelButton: false,
                confirmButtonText: 'Close'
            })
            $('#closeModal').click()
            roomTable()

        },
        error:function(error){
            console.log(error)
        }
    })
})

$('#closeRoomBtn').on('click',function(){
    $('#editRoom').modal('hide')
})

$('#updateRoomBtn').on('click',function(){

    var editRoomName = $('#editRoomName').val()
    var editRoomPrice = $('#editRoomPrice').val()
    var editID = $('#editID').val()

    if(editRoomName==''){
    Swal.fire({
        text: 'Room field must be required !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
    return false;
    }

    if(editRoomPrice==''){
    Swal.fire({
        text: 'Room price must be required !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
    return false;
    }

    if (!/^\d+$/.test(editRoomPrice)) {
    Swal.fire({
        text: 'Room price must be number !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
    return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
        url: "{{ route('admin.room.update', ['room' => ':id']) }}".replace(':id', editID),
        method: 'PATCH',
        data:{
        editRoomName:editRoomName,
        editRoomPrice:editRoomPrice,
        },
        success: function(response) {
            console.log(response)
            Swal.fire({
                text: response.message,
                icon: 'success',
                showCancelButton: false,
                confirmButtonText: 'Close'
            })
            $('#editRoom').modal('hide')
            roomTable()

        },
        error:function(error){
            console.log(error)
        }
    })
})
</script>
{{-- <script>
    function closeModal(e){
        var firstSibling = $(e).prev();
        var parentElement = $(e).closest('[id^="static-modal"]');
        var messageTextarea = parentElement.find('#message');
        var titleTextarea = parentElement.find('#title');
        if (firstSibling.length) {
            firstSibling.css('display', 'inline');
            messageTextarea.css('display', 'inline')
            titleTextarea.css('display', 'inline')
        } else {
            console.log('No sibling found.');
        }
    }
    function sendMessage(e){
        var parentElement = $(e).closest('[id^="static-modal"]');
        var messageTextarea = parentElement.find('#message');
        var titleTextarea = parentElement.find('#title');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
        url: "{{ route('admin.message.store') }}",
        method: 'POST',
        data:{
            title:$('#title').val(),
            message:$('#message').val(),
            user:e.id
        },
        success: function(response) {
        console.log(response)
            if(response.success){
                $('#title').val('')
                $('#message').val('')
                $(e).css('display','none')
                messageTextarea.css('display', 'none')
                titleTextarea.css('display', 'none')
                    Swal.fire({
                    title: 'Message Sent!',
                    text: response.success,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }
        },
        error:function(error){
            console.log(error)
        }
    })

    }
</script> --}}
@endsection
