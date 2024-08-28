@extends('admin.layouts')
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
                    <button class="bg-sky-700 text-white hover:bg-sky-600 btn" type="submit" class="form-control">Search</button>
                </div>
            </form>
        </div>
        <div class="card mb-4">
            <div class="card-header">
               <p class="text-secondary" style="font-size: 1.5rem;"> PAID HISTORY</p>
            </div>
               <div class="card-body">
                @if (Session::has('success'))
                {{-- <div class="text-lg my-2 text-green-600">{{ Session::get('success') }}</div> --}}
                <script>
                    Swal.fire({
                        text:  @json(Session::get('success')),
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
                    text: @json(Session::get('danger')),
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
                                @php
                                    if(isset($activity['totalAmount'])){
                                        $total += (int)$activity['totalAmount']??'';
                                    }
                                @endphp
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
                        <div class="my-3 text-lg"><span class="font-bold">
                            Month of {{ $salary }} ( {{ ' ₱ '.number_format($total) }} )
                        </div>
                      </table>
                      <div class="mt-4">
                        {{ $paginated->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>
<script>
    function updateSalary(){

    }
</script>

@endsection
