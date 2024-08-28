@extends('admin.layouts')
@section('content')
<div class="container">
    <div class="row">
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
                <a href="{{ route('admin.employee.index') }}" class="btn bg-sky-700 text-white hover:bg-sky-600">Back</a>
               </div>
                <div class="card-body">
                    <div class="m-3 text-lg"><span class="font-bold">Total time attempted login today : </span>{{ $user->activities->count() }}
                    </div>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Account</th>
                            <th scope="col">Time In / Out</th>
                            <th scope="col">Type</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->activities as $activity)
                                <tr>
                                    <td>{{ $user->name }}</td>
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
