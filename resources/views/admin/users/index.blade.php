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
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Full name</th>
                            <th scope="col">Gmail</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Warning Count</th>
                            <th scope="col">Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            @if ($user->warning_count>0)
                            <tr class="text-red-600">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ $user->warning_count }}</td>
                                <td>
                                    @if ($user->warning_count==1)
                                        <i class="text-2xl cursor-pointer fa-solid fa-triangle-exclamation" data-modal-target="static-modal{{ $user->id }}" data-modal-toggle="static-modal{{ $user->id }}"></i>
                                        <div id="static-modal{{ $user->id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <!-- Modal body -->
                                                    <div class="p-4 md:p-5 space-y-4">
                                                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">You message to {{ $user->name }}</label>
                                                     <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Title">
                                                    <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..."></textarea>
                                                    </div>
                                                    <div class="pb-4 px-4 md:pb-4 md:px-4 space-y-2">
                                                        <button onclick="sendMessage(this)" id="{{ $user->id }}" class="btn text-white hover:bg-sky-600 bg-sky-700 rounded-md shadow-md" type="button">Send</button>
                                                        <button id="static-close" onclick="closeModal(this)" data-modal-hide="static-modal{{ $user->id }}" type="button" class="btn-sm text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-2 py-2 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 shadow-md">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif ($user->warning_count>=2)
                                       <span class="flex items-center">
                                        <i class="text-2xl mr-5 cursor-pointer fa-solid fa-triangle-exclamation"  data-modal-target="static-modal{{ $user->id }}" data-modal-toggle="static-modal{{ $user->id }}"></i>
                                        <div id="static-modal{{ $user->id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <!-- Modal body -->
                                                    <div class="p-4 md:p-5 space-y-4">
                                                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">You message to {{ $user->name }}</label>
                                                         <input type="text" name="title" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Title">
                                                        <textarea id="message" name="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your message here..."></textarea>
                                                    </div>
                                                    <div class="pb-4 px-4 md:pb-4 md:px-4 space-y-2">
                                                        <button onclick="sendMessage(this)" id="{{ $user->id }}" class="btn text-white hover:bg-sky-600 bg-sky-700 rounded-md shadow-md" type="button">Send</button>
                                                        <button id="static-close" onclick="closeModal(this)" data-modal-hide="static-modal{{ $user->id }}" type="button" class="btn-sm text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-2 py-2 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600 shadow-md" >Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm px-3 bg-red-500 text-white shadow-md hover:bg-red-600">Ban</button>
                                       </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->active==1)
                                        <span class="text-green-600">Active</span>
                                    @elseif($user->active==0)
                                        <span class="text-red-600">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            @else
                            <tr class="text-sky-700">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ $user->warning_count }}</td>
                                <td>
                                    @if ($user->active==1)
                                        <span class="text-green-600">Active</span>
                                    @elseif($user->active==0)
                                        <span class="text-red-600">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->active==1)
                                    <button type="button" data-toggle="modal" data-target="#partialPAID-{{ $user->id }}" class="btn bg-sky-700 hover:bg-sky-600 text-white rounded-md shadow-md">Ban</button>
                                    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="partialPAID-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to ban <b>{{ $user->name }}</b></b>?</h3>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                               <form method="POST" action="{{ route('admin.users.update',$user->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-sky-600 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                   Mark as Ban
                                                 </button>
                                               </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      @elseif($user->active==0)
                                      <button type="button" data-toggle="modal" data-target="#partialPAID-{{ $user->id }}" class="btn bg-green-700 hover:bg-green-600 text-white rounded-md shadow-md">Unban</button>
                                      <div class="modal fade" data-backdrop="static" data-keyboard="false" id="partialPAID-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                  <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to unban <b>{{ $user->name }}</b></b>?</h3>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                                 <form method="POST" action="{{ route('admin.users.unban',$user->id) }}">
                                                  @csrf
                                                  @method('PATCH')
                                                  <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                     Mark as Unban
                                                   </button>
                                                 </form>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    @endif

                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                      </table>
                      <div class="mt-4">
                        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>
<script>
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
</script>
@endsection
