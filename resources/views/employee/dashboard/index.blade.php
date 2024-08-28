@extends('employee.layouts')
@section('content')
<div class="container">
    <div class="row">
        <div class="card mb-2">
            <div class="card-body flex gap-2">
              @if (!$login)
              <button data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#timerModal" class="btn bg-lime-700 hover:bg-lime-600 rounded-md shadow-md text-white">Time-in</button>
              <div class="modal fade" id="timerModal" tabindex="-1" role="dialog" aria-labelledby="timerModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          Start time session?
                      </div>
                      <div class="modal-footer">
                        <form method="POST" action="{{ route('employee.timer.store') }}">
                          @csrf
                          <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn bg-lime-700 hover:bg-lime-600 text-white">Time-in</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              @else
              <button data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#disableModal" class="btn bg-lime-700 hover:bg-lime-600 rounded-md shadow-md text-white">Time-in</button>
              <div class="modal fade" id="disableModal" tabindex="-1" role="dialog" aria-labelledby="disableModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          Timer has been already started
                      </div>
                      <div class="modal-footer">
                          @csrf
                          <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              @endif

              @if (!$logout)
                @if ($login)
                <button data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#timerModalOut" class="btn bg-sky-700 hover:bg-sky-600 rounded-md shadow-md text-white">Time-Out</button>
                <div class="modal fade" id="timerModalOut" tabindex="-1" role="dialog" aria-labelledby="timerModalOutLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            End time session?
                        </div>
                        <div class="modal-footer">
                          <form method="POST" action="{{ route('employee.timer.update',Auth::id()) }}">
                            @csrf
                            @method("PATCH")
                            <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-sky-700 hover:bg-sky-600 text-white">End Time</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
                @else
                <button data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#timerModalOut" class="btn bg-sky-700 hover:bg-sky-600 rounded-md shadow-md text-white">Time-Out</button>
                <div class="modal fade" id="timerModalOut" tabindex="-1" role="dialog" aria-labelledby="timerModalOutLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            You can't logout anymore please contact your admin
                        </div>
                        <div class="modal-footer">
                            @csrf
                            <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="card mb-4">
               <div class="card-body">
                @if (Session::has('success'))
                {{-- <div class="text-lg my-2 text-green-600">{{ Session::get('success') }}</div> --}}
                <script>
                    Swal.fire({
                        text: @json(Session::get('success')),
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
                    <div class="m-3 text-lg"><span class="font-bold">Total time login today : </span>{{ $timer }}
                    </div>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Time In / Out</th>
                            <th scope="col">Type</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ date("M d Y, h:i a",strtotime($activity->created_at)) }}</td>
                                    <td>{{ Str::ucfirst($activity->event) }}</td>
                                </tr>
                            @endforeach
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

@endsection
