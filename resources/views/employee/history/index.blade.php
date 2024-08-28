@extends('employee.layouts')
@section('content')
<div class="container">
    <div class="row">
        <div class="mb-2">
            <a href="{{ route('admin.employee.index') }}" class="btn bg-sky-700 text-white hover:bg-sky-600">Back</a>
              </div>
        </div>
        @php
        $total = 0;
        @endphp
        <div class="my-3">
            <form method="GET" class="flex gap-3">
                <div class="form-group w-full">
                    <select name="search" class="form-control">
                        <option value="">Select month</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="form-group w-full">
                    <button  class="bg-sky-700 text-white hover:bg-sky-600 btn" type="submit" class="form-control">Search</button>
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
                    {{-- <div class="m-3 text-lg"><span class="font-bold">Total time login : </span>{{ $timer }}
                    <span>Login at </span>
                    </div> --}}
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Time in</th>
                            <th scope="col">Time out</th>
                            <th scope="col">Total Hours</th>
                            <th scope="col">Salary</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                @php
                                    $total +=  $activity['totalAmount']??'';
                                @endphp
                                <tr>
                                    <td><a class="text-sky-700" href="{{ route('employee.history.show',$activity['date']) }}">{{ date("M d , Y",strtotime($activity['date'])) }}</a></td>
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
                      <div class="my-3 text-lg"><span class="font-bold">
                        Month of
                        @if ($salary)
                        {{ \Carbon\Carbon::createFromFormat('m', $salary)->format('F') }} ({{ '₱ '.number_format($total) }})
                        @else
                        Salary ({{ '₱ '.number_format($total) }})
                        @endif
                      </div>
                      <div class="mt-4">
                        {{ $paginated->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>

@endsection
