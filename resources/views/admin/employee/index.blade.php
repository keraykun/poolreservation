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
                <button type="button" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#addEmployee" class="btn-sm btn bg-green-700 hover:bg-green-800 text-white rounded-md shadow-md" href="">NEW EMPLOYEE</button>

                <!-- Modal -->
                <div class="modal fade" id="addEmployee" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="addEmployeeModalLabel"></h5>
                        <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="employeeName">Employee name</label>
                                <input type="text" id="employeeName" class="form-control" aria-describedby="emailHelp">

                            </div>
                            <div class="form-group">
                                <label for="employeeEmail">Employee email</label>
                                <input type="email" id="employeeEmail" class="form-control"  aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="employeeContact">Employee contact</label>
                                <input type="text" id="employeeContact" class="form-control"  aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn bg-slate-700 hover:bg-slate-800 text-white rounded-md shadow-md" data-dismiss="modal">Close</button>
                        <button id="employeeBtn" type="button" class="btn btn-sm btn bg-green-700 hover:bg-green-800 text-white rounded-md shadow-md">Save changes</button>
                        </div>
                    </div>
                    </div>
                </div>
                 <!-- end Modal -->

                  <!--Edit Modal -->
                <div class="modal fade" id="editEmployee" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="editEmployeeModalLabel"></h5>

                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="editEmployeeName">Employee name</label>
                                <input type="text" id="editEmployeeName" class="form-control" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="editEmployeeEmail">Employee email</label>
                                <input type="email" id="editEmployeeEmail" class="form-control"  aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="editEmployeeContact">Employee contact</label>
                                <input type="text" id="editEmployeeContact" class="form-control"  aria-describedby="emailHelp">
                            </div>
                            <input type="hidden" id="editID" class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="closeEmployeeBtn" class="btn btn-sm btn bg-slate-700 hover:bg-slate-800 text-white rounded-md shadow-md" data-dismiss="modal">Close</button>
                        <button id="updateEmployeeBtn"  type="button" class="btn btn-sm btn bg-green-700 hover:bg-green-800 text-white rounded-md shadow-md">Update changes</button>
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
                            <th scope="col">Employee account</th>
                            <th scope="col">Employee name</th>
                            <th scope="col">Employee contact</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody id="employeeTable">

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
function employeeTable(){
    $.ajax({
        url: "{{ route('admin.employee.list') }}",
        method: 'GET',
        success: function(response) {
            // Append the retrieved data to the table body
            $('#employeeTable').html(response);
        },
        error: function(error) {
            console.error('Error fetching data: ', error);
        }
    });
}

function editEmployee(id) {

    $('#editEmployee').modal({
        backdrop: 'static',
        keyboard: false
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ route('admin.employee.edit', ['employee' => ':id']) }}".replace(':id', id),
        method: 'GET',
        success: function (response) {
            $('#editEmployee').modal('show')
            $('#editEmployeeName').val(response.name)
            $('#editEmployeeEmail').val(response.email)
            $('#editEmployeeContact').val(response.contact)
            $('#editID').val(response.id)

        },
        error: function (error) {
            console.log(error);
        }
    });
}

function deleteEmployee(id) {
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
            url: "{{ route('admin.employee.destroy', ['employee' => ':id']) }}".replace(':id', id),
            method: 'DELETE',
            success: function (response) {

                Swal.fire({
                    text: response.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Close'
                });

                employeeTable();
            },
            error: function (error) {
                console.log(error);
            }
        });

        }
    });

}

employeeTable()

$('#employeeBtn').on('click',function(){

   var employeeName = $('#employeeName').val()
   var employeeEmail = $('#employeeEmail').val()
   var employeeContact = $('#employeeContact').val()

   if(employeeName==''){
    Swal.fire({
        text: 'Employee name field must be required !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
     return false;
   }


   function isValidEmail(email) {
    // Regular expression for a simple email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Your validation code


    if (employeeEmail === '') {
        Swal.fire({
            text: 'Employee email field must be required!',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Close'
        });
        return false;
    } else if (!isValidEmail(employeeEmail)) {
        Swal.fire({
            text: 'Please enter a valid email address!',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Close'
        });
        return false;
    }

   if (!/^\d+$/.test(employeeContact)) {
    Swal.fire({
        text: 'Employee contact must be number !',
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
        url: "{{ route('admin.employee.store') }}",
        method: 'POST',
        data:{
            employeeName:employeeName,
            employeeEmail:employeeEmail,
            employeeContact:employeeContact
        },
        success: function(response) {
            console.log(response)
            Swal.fire({
                text: response.message,
                icon: 'success',
                showCancelButton: false,
                confirmButtonText: 'Close'
            })
            $('#closeModal').click()
            employeeTable()

        },
        error:function(error){
            console.log(error)
        }
    })
})

$('#closeEmployeeBtn').on('click',function(){
    $('#editEmployee').modal('hide')
})

$('#updateEmployeeBtn').on('click',function(){

    var editEmployeeName = $('#editEmployeeName').val()
    var editEmployeeEmail = $('#editEmployeeEmail').val()
    var editEmployeeContact = $('#editEmployeeContact').val()
    var editID = $('#editID').val()

    if(editEmployeeName==''){
    Swal.fire({
        text: 'Employee name field must be required !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
    return false;
    }

    if(editEmployeeEmail==''){
    Swal.fire({
        text: 'Employee email field must be required !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
    return false;
    }

    if(editEmployeeContact==''){
    Swal.fire({
        text: 'Employee contact must be required !',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Close'
    })
    return false;
    }

    if (!/^09\d{9}$/.test(editEmployeeContact)) {
        Swal.fire({
            text: 'Employee contact must be number !',
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
        url: "{{ route('admin.employee.update', ['employee' => ':id']) }}".replace(':id', editID),
        method: 'PATCH',
        data:{
            editEmployeeName:editEmployeeName,
            editEmployeeEmail:editEmployeeEmail,
            editEmployeeContact:editEmployeeContact,
        },
        success: function(response) {

            Swal.fire({
                text: response.message,
                icon: 'success',
                showCancelButton: false,
                confirmButtonText: 'Close'
            })
            $('#editEmployee').modal('hide')
            employeeTable()

        },
        error:function(error){
            console.log(error)
        }
    })
})
</script>

@endsection
