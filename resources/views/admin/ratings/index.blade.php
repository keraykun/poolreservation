@extends('admin.layouts')
@section('content')
<style>
    #primaryBody{
        background: white;
    }
    header{
        border: none !important;
    }
    .wrapper{
        background: white !important;
    }
     .rate1,.rate2,.rate3,.rate4 {
    float: left;
    height: 46px;
    /* padding: 0 0px; */
    }
    .text-label{
    color: #ffc700;
    }
    .rate1:not(:checked) > label,
    .rate2:not(:checked) > label,
    .rate3:not(:checked) > label,
    .rate4:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
    }
    .rate1:not(:checked) > label.notchecked,
    .rate2:not(:checked) > label.notchecked,
    .rate3:not(:checked) > label.notchecked,
    .rate4:not(:checked) > label.notchecked {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
    }
    .rate1:not(:checked) > label.checked,
    .rate2:not(:checked) > label.checked,
    .rate3:not(:checked) > label.checked,
    .rate4:not(:checked) > label.checked {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ffc700;
    }
    .rate1:not(:checked) > label:before,
    .rate2:not(:checked) > label:before,
    .rate3:not(:checked) > label:before,
    .rate4:not(:checked) > label:before {
    content: '★ ';
    }
</style>
<div class="container bg-white">
    <div class="row  bg-white">
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
        <div class="card mb-4" style="background: white !important; border:none;">
                <div class="card-body" style="background: white !important;">
                <div style="min-width: 1200px; overflow:hidden; padding:10px;">
                    <table class="min-w-full bg-white border-none">
                        <thead>
                          <tr>
                            <th scope="col">Account name</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Caterings Rating</th>
                            <th scope="col">Room Rating</th>
                            <th scope="col">Pool Rating</th>
                            <th scope="col">Staff Rating</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($ratings as $rating)
                                <tr>
                                    <td>{{ $rating->booking->user->name }}</td>
                                    <td>{{ Str::limit($rating->comment->comments, 20, '... More') }}</td>
                                    <td>
                                        @switch($rating->food->star)
                                        @case(5)
                                             <div class="rate1">
                                                 <label class="checked">5 stars</label>
                                                 <label class="checked">4 stars</label>
                                                 <label class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(4)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="checked">4 stars</label>
                                                 <label  class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(3)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(2)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="notchecked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(1)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="notchecked">3 stars</label>
                                                 <label class="notchecked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                       @default
                                         <span>error</span>
                                   @endswitch
                                 </span>
                                    </td>
                                    <td>
                                        @switch($rating->room->star)
                                        @case(5)
                                             <div class="rate1">
                                                 <label class="checked">5 stars</label>
                                                 <label class="checked">4 stars</label>
                                                 <label class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(4)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="checked">4 stars</label>
                                                 <label  class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(3)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(2)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="notchecked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(1)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="notchecked">3 stars</label>
                                                 <label class="notchecked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                       @default
                                         <span>error</span>
                                   @endswitch
                                 </span>
                                    </td>
                                    <td>
                                        @switch($rating->pool->star)
                                        @case(5)
                                             <div class="rate1">
                                                 <label class="checked">5 stars</label>
                                                 <label class="checked">4 stars</label>
                                                 <label class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(4)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="checked">4 stars</label>
                                                 <label  class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(3)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(2)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="notchecked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(1)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="notchecked">3 stars</label>
                                                 <label class="notchecked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                       @default
                                         <span>error</span>
                                   @endswitch
                                 </span>
                                    </td>
                                    <td>
                                        @switch($rating->staff->star)
                                        @case(5)
                                             <div class="rate1">
                                                 <label class="checked">5 stars</label>
                                                 <label class="checked">4 stars</label>
                                                 <label class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(4)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="checked">4 stars</label>
                                                 <label  class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(3)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="checked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(2)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="notchecked">3 stars</label>
                                                 <label class="checked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                         @case(1)
                                             <div class="rate1">
                                                 <label  class="notchecked">5 stars</label>
                                                 <label  class="notchecked">4 stars</label>
                                                 <label  class="notchecked">3 stars</label>
                                                 <label class="notchecked">2 stars</label>
                                                 <label class="checked">1 star</label>
                                             </div>
                                         @break
                                       @default
                                         <span>error</span>
                                   @endswitch
                                 </span>
                                    </td>
                                    <td>
                                        <button type="button" data-toggle="modal" data-target="#modalDelete-{{ $rating->id }}" class="py-2 px-3 bg-orange-700 hover:bg-orange-600 btn-sm text-white rounded-md shadow-md"><i class="fa fa-trash"></i></button>

                                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalDelete-{{ $rating->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <h3 class="text-lg font-normal text-gray-500 dark:text-gray-400 text-center">Are you sure you want to delete this ?</h3>
                                                </div>
                                                <div class="modal-footer">
                                                <form action="{{ route('admin.rating.destroy',$rating->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="py-2 px-3 rounded-md bg-slate-600 hover:bg-slate-500  btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" data-modal-hide="popup-modal" href="" class="text-white bg-orange-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        Delete
                                                     </button>
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
                </div>
                      <div class="mt-4">
                        {{ $ratings->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>
@endsection
