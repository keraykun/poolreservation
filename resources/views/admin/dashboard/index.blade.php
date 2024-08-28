@extends('admin.layouts')
@section('content')
<style>
    .card-counter{
    box-shadow: 2px 2px 10px #DADADA;
    margin: 5px;
    padding: 20px 10px;
    background-color: #fff;
    height: 100px;
    border-radius: 5px;
    transition: .3s linear all;
  }

  .card-counter:hover{
    box-shadow: 4px 4px 20px #DADADA;
    transition: .3s linear all;
  }

  .card-counter.primary{
    background-color: #007bff;
    color: #FFF;
  }

  .card-counter.danger{
    background-color: #ef5350;
    color: #FFF;
  }

  .card-counter.success{
    background-color: #66bb6a;
    color: #FFF;
  }

  .card-counter.info{
    background-color: #26c6da;
    color: #FFF;
  }

  .card-counter i{
    font-size: 5em;
    opacity: 0.2;
  }

  .card-counter .count-numbers{
    position: absolute;
    right: 35px;
    top: 20px;
    font-size: 32px;
    display: block;
  }

  .card-counter .count-name{
    position: absolute;
    right: 35px;
    top: 65px;
    font-style: italic;
    text-transform: capitalize;
    opacity: 0.5;
    display: block;
    font-size: 18px;
  }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4" style="background: #007bff;">
                 <div class="card-body">
                    <div class="p-2 my-2 font-medium text-white">
                        Employee working today
                    </div>
                     {{-- <div class="m-3 text-lg"><span class="font-bold">Total time login : </span>{{ $timer }}
                     <span>Login at </span>
                     </div> --}}
                     <table class="table">
                         <thead>
                           <tr class="text-white">
                             <th scope="col">Account</th>
                             <th scope="col">Date</th>
                             <th scope="col">Time in</th>
                             <th scope="col">Time out</th>
                             <th scope="col">Hours Worked</th>
                             <th scope="col">Total Attempted</th>
                             <th scope="col">Salary</th>
                           </tr>
                         </thead>
                         <tbody>
                             @foreach ($activities as $activity)
                                 <tr class="text-white">
                                     <td><a style="text-decoration:underline;" href="{{ route('admin.employee.history',$activity['user']->id) }}">{{ $activity['user']->name??'' }}</a></td>
                                     <td>{{ date("M d , Y",strtotime($activity['firstLoginDate'])) }}</td>
                                     <td>{{ date("h:i a",strtotime($activity['firstLoginDate'])) }}</td>
                                     <td>
                                         @if ($activity['lastLogoutDate']!=null)
                                         {{ date("h:i a",strtotime($activity['lastLogoutDate'])) }}
                                         @endif
                                     </td>
                                     <td>{{ $activity['hoursWorked']??'' }}</td>
                                     <td><a style="text-decoration:underline;" href="{{ route('admin.employee.show',$activity['user']->id) }}">{{ $activity['user']->activities_count??'' }}</a></td>
                                     <td>₱ {{ number_format($activity['totalAmount']??'') }}</td>
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
        </div>
        <div class="container flex flex-col gap-5">
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ route('admin.bookings.index') }}">
                        <div class="card-counter info">
                            <i class="fa fa-book"></i>
                            <span class="count-numbers">{{ $bookings_pending }}</span>
                            <span class="count-name">Bookings Pending</span>
                        </div>
                    </a>
                  </div>
                  <div class="col-md-3">
                    <a href="{{ route('admin.bookings.index') }}">
                    <div class="card-counter success">
                      <i class="fa fa-book"></i>
                      <span class="count-numbers">{{ $bookings_reserve }}</span>
                      <span class="count-name">Bookings Reserve</span>
                    </div>
                    </a>
                  </div>
                  <div class="col-md-3">
                    <a href="{{ route('admin.bookings.index') }}">
                    <div class="card-counter danger">
                      <i class="fa fa-book"></i>
                      <span class="count-numbers">{{ $bookings_paid }}</span>
                      <span class="count-name">Bookings Unavailable</span>
                    </div>
                    </a>
                  </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.bookings.index') }}">
                    <div class="card-counter" style="background: #5c5470; color:white;">
                        <i class="fa fa-book"></i>
                        <span class="count-numbers">{{ $bookings_expired }}</span>
                        <span class="count-name">Bookings Cancelled</span>
                    </div>
                    </a>
                </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                <a href="{{ route('admin.foods.index') }}">
                <div class="card-counter primary">
                <i class="fa fa-pizza-slice"></i>
                <span class="count-numbers">{{ $foods_count }}</span>
                <span class="count-name">Foods</span>
                </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.room.index') }}">
              <div class="card-counter danger">
                <i class="fa fa-house"></i>
                <span class="count-numbers">{{ $room_count }}</span>
                <span class="count-name">Room</span>
              </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.employee.index') }}">
              <div class="card-counter success">
                <i class="fa fa-users"></i>
                <span class="count-numbers">{{ $employee_count }}</span>
                <span class="count-name">Employee</span>
              </div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.bookings.index') }}">
              <div class="card-counter info">
                <i class="fa fa-users"></i>
                <span class="count-numbers">{{ $users_count }}</span>
                <span class="count-name">Users</span>
              </div>
                </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
                <a href="{{ route('admin.concern.index') }}">
              <div class="card-counter primary">
                <i class="fa fa-envelope"></i>
                <span class="count-numbers">{{ $concern_count }}</span>
                <span class="count-name">Concern Email</span>
              </div>
                </a>
            </div>
          </div>
        </div>
        @if($announcement!==null)

        <section class="p-5 rounded-sm flex flex-row flex-wrap items-center justify-center w-full gap-5 xs:m-h-min">
         <section class="p-5 rounded-sm flex flex-row flex-wrap items-center justify-center w-full gap-5">
            <div class="bg-white border border-gray-200 drop-shadow-md w-full">
                 <div class="xl:h-[120px]  md:h-20">
                     <div class="xl:text-2xl xl:text-lg font-bold flex items-center drop-shadow-lg justify-start bg-sky-600 h-full backdrop-brightness-[0.85] w-full text-white uppercase" >
                         <img class="xl:w-64 md:w-32 xs:w-24 xxs:w-24" src="{{ asset('images/all/phone.png') }}" alt="">
                         <span class=" text-white recentannouncement-text">Latest Announcements</span>
                     </div>
                 </div>
                 <div class="p-4 flex items-start w-full rounded-xl xxs:flex-col lg:flex-row md:flex-row" >
                     <div class="mr-4 p-3 recentannouncement-text xxs:flex-row xxs:gap-2 xxs:my-2 lg:gap-0 xl:gap-0 md:gap-0  lg:my-0 xl:my-0 md:my-0  text-white flex md:flex-col xl:flex-col lg:flex-col items-center justify-center bg-yellow-500">
                     <span class="md:text-md xl:text-lg xs:text-md font-bold">{{ date('M',strtotime($announcement->due_at??'')) }}</span>
                     <h1 class="md:text-2xl xl:text-6xl xs:text-md font-bold">{{ date('d',strtotime($announcement->due_at??'')) }}</h1>
                     <span class="md:text-textmd xl:text-lg xs:text-md font-bold">{{ date('Y',strtotime($announcement->due_at??'')) }}</span>
                     </div>
                     <div>
                     <a href="#" class="flex gap-x-3">
                         <span class="  border-l-4 border-green-700"></span>
                         <div class="my-3text-slate-700  font-bold">
                             <h5 class=" xl:text-2xl xl:text-lg xs:text-md tracking-tight"> Pool Promos !</h5>
                             <small class="ml-2"><i>Date Posted : {{ date('M d, Y h:i: a',strtotime($announcement->due_at??'')) }}</i></small>
                         </div>
                     </a>
                     <div class="xl:my-4 md:my-1 font-norma px-7 text-start py-3 whitespace-pre-line dark:text-gray-400 indent-7 text-slate-700 md:text-sm xl:text-xl xs:text-sm" style="font-weight: 500;">
                        <p class="font-bold uppercase">{{ $announcement->title??'' }}</p>
                        <p class="indent-7">   {{ $announcement->description??'' }}</p>
                     </div>
                     </div>
                 </div>
             </div>
         </section>
     </section>

        @endif
    </div><!-- /.row-->
</div>
@endsection
