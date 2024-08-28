@extends('home.layout')
@section('content')
<main>
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
    @endif
    <section  style="min-height:600px;"  class="py-5 rounded-sm flex flex-row flex-wrap items-start justify-start w-full gap-5 ">
        <div class="md:w-[90%] h-[700px] flex flex-col items-center justify-start px-3 py-8 mx-auto  lg:py-0">
            <section class="flex flex-col items-center justify-start">
                <div class="title w-full text-center mt-20">
                    <p class="text-4xl text-slate-800 font-bold">Get in touch</p>
                </div>
                <div class=" border-t-4 mt-10 border-yellow-500 h-20 w-24">

                </div>
            </section>
            <section class="w-full flex justify-between ">
                <div class="flex flex-col gap-7">
                    <div>
                        <p class="text-4xl font-bold">Barril's Private Resort</p>
                        <p class="text-lg">Municipality of Maramag, Mindanao Philippines</p>
                    </div>
                    <div class="text-2xl">
                        <p><span class="font-bold">Reservations : </span><span class="text-yellow-500">reservations@gmail.com</span></p>
                        <p><span class="font-bold">Events : </span><span class="text-yellow-500">reservations@gmail.com</span></p>
                    </div>
                    <div class="text-2xl flex flex-col gap-5">
                        <p class="text-xl">For more inquires, you may contact us at : </p>
                        <div>
                            <p class="text-xl font-bold">Reservations / Resort Mobile No.</p>
                        </div>
                        <div>
                            <p><span>+63935 673 2423</span><span>( Monday ~ Sunday, 8:00 am - 6:00 pm)</span></p>
                            <p><span>+63926 022 1293</span><span>( Monday ~ Sunday, 8:00 am - 6:00 pm)</span></p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="w-full p-6 px-10 bg-white border border-black rounded-lg shadow dark:bg-gray-800 dark:border-gray-700" style="box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
                    -webkit-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);
                    -moz-box-shadow: 10px 10px 5px 0px rgba(70,107,94,0.75);">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Email us</h5>
                        </a>
                       <div>

                        <form class="max-w-md mx-auto" method="POST" accept="{{ route('home.contact.store') }}">
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="text" name="name" id="name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Full name</label>
                                @error('name')
                                    <small class="text-red-600">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="email" name="email" id="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email address</label>
                                @error('email')
                                    <small class="text-red-600">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="text" name="contact" id="contact" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                                <label for="contact" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Contact</label>
                                @error('contact')
                                    <small class="text-red-600">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="relative z-0 w-full mb-5 group">
                                 <textarea name="message" id="message" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " cols="60" rows="3"></textarea>
                                <label for="message" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Message</label>
                                @error('message')
                                    <small class="text-red-600">{{ $message }}</small>
                                @enderror
                            </div>
                            @csrf
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </form>

                       </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</main>
@endsection
