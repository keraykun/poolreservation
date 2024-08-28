@extends('admin.layouts')
@section('content')
<div class="container">
    <div class="row">
        {{-- <div class="my-3">
            <form method="GET">
                <div class="relative flex gap-3">
                    <select name="" id="" class="w-[200px] p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="01">Jan</option>
                        <option value="02">Feb</option>
                        <option value="03">Mar</option>
                        <option value="04">Apr</option>
                        <option value="05">May</option>
                        <option value="06">Jun</option>
                        <option value="07">Jul</option>
                        <option value="08">Aug</option>
                        <option value="09">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                    <input type="search" id="default-search" name="search" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
        </div> --}}
        {{-- <div class="my-3">
            <form method="GET" class="flex gap-3">
                <div class="form-group w-full">
                    <select name="search" id="" class="form-control">
                        <option value="01">Jan</option>
                        <option value="02">Feb</option>
                        <option value="03">Mar</option>
                        <option value="04">Apr</option>
                        <option value="05">May</option>
                        <option value="06">Jun</option>
                        <option value="07">Jul</option>
                        <option value="08">Aug</option>
                        <option value="09">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                </div>
                <div class="form-group w-full">
                    <button class="bg-sky-700 text-white hover:bg-sky-600 btn" type="submit" class="form-control">Search</button>
                </div>
            </form>
        </div> --}}
        <div class="card mb-4">
               <div class="card-body">
               {{-- @if ($search)
                   <p class="font-bold text-lg">Month of {{ $search }}</p>
               @endif --}}
               </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">User</th>
                            <th scope="col">Title</th>
                            <th scope="col">Total Messages</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                            <tr>
                               <td>{{ $message->client->name }}</td>
                               <td>{{ $message->title }}</td>
                               <td>{{ $message->total_message }}</td>
                               <td><a href="{{ route('admin.warning.show',$message->id) }}" class="btn bg-sky-700 hover:bg-sky-700 text-white shadow-md rounded-md">Show</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div class="mt-4">
                        {{-- {{ $incomes->withQueryString()->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.row-->
</div>

@endsection
