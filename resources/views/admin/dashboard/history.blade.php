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
                    {{-- <div class="m-3 text-lg"><span class="font-bold">Total time login : </span>{{ $timer }}
                    <span>Login at </span>
                    </div> --}}
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Account</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time in</th>
                            <th scope="col">Time out</th>
                            <th scope="col">Total Hours</th>
                            <th scope="col">Salary</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $activity['name']??'' }}</td>
                                    <td>{{ date("M d , Y",strtotime($activity['date'])) }}</td>
                                    <td>{{ date("h:i a",strtotime($activity['firstLogin'])) }}</td>
                                    <td>
                                        @if ($activity['lastLogout']!=null)
                                        {{ date("h:i a",strtotime($activity['lastLogout'])) }}
                                        @endif
                                    </td>
                                    <td>{{ $activity['hours']??'' }}</td>
                                    <td>₱ {{ $activity['totalAmount']??'' }}</td>
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
