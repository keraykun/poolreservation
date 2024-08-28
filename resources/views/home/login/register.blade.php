@extends('home.layout')
@section('content')
<main>
    <section class="p-5 rounded-sm flex flex-row flex-wrap items-start justify-start w-full gap-5">
        <div class="md:w-[50%] flex flex-col items-start justify-start px-6 py-8 mx-auto sm:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0  xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Register on to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('guest.store') }}">
                        @csrf
                        <div>
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Full name</label>
                            <input type="text" name="name" value="{{ old('name') }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter Fullname">
                            @error('name')
                            <p class="text-red-500"> {{ $message }}</p>
                             @enderror
                        </div>
                        <div>
                            <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Contact number</label>
                            <input type="text" name="contact" value="{{ old('contact') }}" id="contact" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" maxlength="11" placeholder="09XXXXXXXX">
                            @error('contact')
                               <p class="text-red-500"> {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}" id="email" placeholder="Enter email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @error('email')
                            <p class="text-red-500"> {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" value="{{ old('password') }}" name="password" id="password" placeholder="Enter Password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @error('password')
                            <p class="text-red-500"> {{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                            <input type="password" value="{{ old('password_confirmation') }}"  name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @error('password_confirmation')
                            <p class="text-red-500"> {{ $message }}</p>
                         @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5 gap-3">
                                  <button type="submit" class="bg-blue-400 text-white py-2 px-4 rounded-md">Register</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
       function validateNumber(event){

       }
    </script>
    <script>
        // $("#contact").on('input',function (event) {
        //     const inputString = $(this).val();
        //         const regex = /^09\d{11}$/;
        //         if (inputString.startsWith("09",0)) {

        //             console.log("Valid inpuxxxxt");

        //         } else {
        //             console.log("Invalid input");
        //         }
        // })
      </script>
</main>
@endsection
