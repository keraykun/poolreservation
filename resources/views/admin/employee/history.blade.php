@extends('admin.layouts')
@section('content')
<div class="container">
    <div class="row">
        <div class="mb-2">
            <a href="{{ route('admin.employee.index') }}" class="btn bg-sky-700 text-white hover:bg-sky-600">Back</a>
              </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <p class="text-secondary" style="font-size: 1.5rem;"> UNPAID HISTORY</p>
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
                <button data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#addModal" class="btn bg-lime-700 hover:bg-lime-600 rounded-md shadow-md text-white">Start Time-in</button>

                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="timerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <form method="POST" action="{{ route('admin.timer.store') }}">
                            @csrf
                        <div class="modal-header">
                            <h1><b>START TIME IN</b></h1>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                            <div class="mb-2 text-secondary"><span class="font-bold">Employee account : </span><span>{{ $employee->name }}</span></div>
                            <div class>
                                <label for="" class="text-secondary">Start time</label>
                                <input type="hidden" value="{{ $employee->id }}" name="user_id">
                                <input type="datetime-local" class="form-control" name="start_time"  id="">
                            </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-lime-700 hover:bg-lime-600 text-white">Time-in</button>
                        </div>
                      </form>
                      </div>
                    </div>

               </div>

                <div class="card-body" id="printable-content">
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
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($activities as $activity)
                                <tr>
                                    @php
                                      if(isset($activity['logout_id'])){
                                        $total += (int)$activity['totalAmount']??'';
                                      }
                                    @endphp
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
                                    <td>
                                        <button data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#timerModal-{{ $activity['login_id'] }}" class="timeInBtn btn bg-lime-700 hover:bg-lime-600 rounded-md shadow-md text-white">Update Time-in</button>

                                        <div class="modal fade" id="timerModal-{{ $activity['login_id'] }}" tabindex="-1" role="dialog" aria-labelledby="timerModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <form method="POST" action="{{ route('admin.timer.timein',$activity['login_id']) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                <div class="modal-header">
                                                    <h1><b>UPDATE TIME IN</b></h1>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                   <div class="form-group">
                                                    <div class="mb-2 text-secondary"><span class="font-bold">Employee account : </span><span>{{ $activity['name']??'' }}</span></div>
                                                    <div class="mb-2 text-secondary"><span class="font-bold">Date : </span><span>{{ date("M d , Y",strtotime($activity['date'])) }}</span></div>
                                                    <div class="mb-2 text-secondary"><span class="font-bold">Current start time: </span><span>{{ date("h:i a",strtotime($activity['firstLogin'])) }}</span></div>
                                                    <input type="hidden" name="login_id" value="{{ $activity['login_id'] }}" id="">
                                                    <input type="hidden" name="start_date" value="{{ $activity['date'] }}" id="">
                                                    <input type="time" required value="" class="form-control" name="start_time"  id="">
                                                   </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn bg-lime-700 hover:bg-lime-600 text-white">Time-in</button>
                                                </div>
                                            </form>
                                              </div>
                                            </div>
                                          </div>

                                @if ($activity['logout_id'])
                                <button data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#timerModalOut-{{ $activity['logout_id'] }}" class="timeOutBtn btn bg-sky-700 hover:bg-sky-600 rounded-md shadow-md text-white">Update Time-Out</button>
                                <div class="modal fade" id="timerModalOut-{{ $activity['logout_id'] }}" tabindex="-1" role="dialog" aria-labelledby="timerModalOutLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.timer.timeout',$activity['logout_id']) }}">
                                                @csrf
                                                @method('PATCH')
                                            <div class="modal-header">
                                                <h1><b>UPDATE TIME OUT</b></h1>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                               <div class="form-group">
                                                <div class="mb-2 text-secondary"><span class="font-bold">Employee account : </span><span>{{ $activity['name']??'' }}</span></div>
                                                <div class="mb-2 text-secondary"><span class="font-bold">Date : </span><span>{{ date("M d , Y",strtotime($activity['date'])) }}</span></div>
                                                <div class="mb-2 text-secondary"><span class="font-bold">Current start time: </span><span>{{ date("h:i a",strtotime($activity['lastLogout'])) }}</span></div>
                                                <input type="hidden" name="logout_id" value="{{ $activity['logout_id'] }}" id="">
                                                <input type="hidden" name="start_date" value="{{ $activity['date'] }}" id="">
                                                <input type="time" required value="" class="form-control" name="end_time"  id="">
                                               </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn bg-sky-700 hover:bg-sky-600 text-white">Time-out</button>
                                            </div>
                                        </form>
                                          </div>
                                    </div>
                                    </div>
                                @else

                                <button data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#timerModalOut" class="timeOutBtn btn bg-sky-700 hover:bg-sky-600 rounded-md shadow-md text-white">Insert Time-Out</button>
                                <div class="modal fade" id="timerModalOut" tabindex="-1" role="dialog" aria-labelledby="timerModalOutLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.timer.out') }}">
                                                @csrf
                                            <div class="modal-header">
                                                <h1><b>INSERT TIME OUT</b></h1>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                               <div class="form-group">
                                                <div class="mb-2 text-secondary"><span class="font-bold">Employee account : </span><span>{{ $activity['name']??'' }}</span></div>
                                                <div class="mb-2 text-secondary"><span class="font-bold">Date : </span><span>{{ date("M d , Y",strtotime($activity['date'])) }}</span></div>
                                                <input type="hidden" name="start_date" value="{{ $activity['date'] }}" id="">
                                                <input type="hidden" name="user_id" value="{{ $activity['user_id'] }}" id="">
                                                <input type="time" required value="" class="form-control" name="end_time"  id="">
                                               </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn bg-sky-700 hover:bg-sky-600 text-white">Time-out</button>
                                            </div>
                                        </form>
                                          </div>
                                    </div>
                                    </div>

                                @endif
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div class="mt-4">
                            @php
                            echo  'Total salary unpaid  ( ₱ '.number_format($total).' ) ';
                        @endphp
                     </div>
            </div>
            <div class="card-body">
                <button data-toggle="modal"  data-backdrop="static" data-keyboard="false" data-target="#releaseSalary" class="btn bg-sky-700 hover:bg-sky-600 rounded-md shadow-md text-white">Release Salary</button>
                <button onclick="printContent({{ $employee->id }})" class="btn text-white rounded-md shadow-md bg-blue-600 hover:bg-blue-700">Print</button>
                <div class="modal fade" id="releaseSalary" tabindex="-1" role="dialog" aria-labelledby="timerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.timer.release') }}">
                            @csrf
                        <div class="modal-header">
                            <h1><b>RELEASE SALARY?</b></h1>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" value="{{ $employee->id }}" name="user_id" >
                        <div class="form-group">
                            <div class="mb-2 text-secondary"><span class="font-bold">Employee account : </span><span>{{ $employee->name }}</span></div>
                        <div class="text-secondary">
                            @php
                            echo  'Total salary unpaid  ( ₱ '.number_format($total).' ) ';
                        @endphp
                        </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-slate-700 hover:bg-slate-600 text-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-sky-700 hover:bg-sky-600 text-white">Release</button>
                        </div>
                    </form>
                    </div>
                    </div>

                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>
<script>
        function printContent(e){

            $('#printable-content').printThis({
                beforePrint: function(){
                    $('.timeInBtn').css('display','none')
                    $('.timeOutBtn').css('display','none')
                },
                afterPrint: function(){
                    $('.timeInBtn').css('display','inline')
                    $('.timeOutBtn').css('display','inline')
                }
            });
        }
</script>
@endsection
