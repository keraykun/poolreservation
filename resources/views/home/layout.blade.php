<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barril Private Resort</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/pool.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.2.0/dist/flowbite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.2.0/dist/flowbite.min.js"></script>
    <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">

    @vite('resources/css/app.css')
    <style>
    *{
        font-family: 'Poppins';
    }
    .barril-private-text{
    font-family: 'Dancing Script', cursive;
    font-family: 'Pacifico', cursive;
    font-size: 2.2rem;
    font-weight: bold;
    text-shadow: 2px 4px 3px rgba(25, 7, 92, 0.822);
    letter-spacing: 1px;
    }
    </style>
    <style>
    .hero-bg-picture{
    background-image: url('{{ asset('images/home/announcement/a.jpg') }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: bottom center;
    position:absolute;
    left:0px;
    right:0px;
    }
    .shadow-owl::before{
    content:'';
    background: white;
    position: absolute;
    width: 1550px;
    height: 560px;
    right: -20px;
    top: 490px;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }
    </style>
    <style>
    .rate1,.rate2,.rate3,.rate4 {
    float: left;
    height: 46px;
    padding: 0 10px;
    }
    .text-label{
    color: #ffc700;
    }
    .rate1:not(:checked) > label,
    .rate2:not(:checked) > label,
    .rate3:not(:checked) > label,
    .rate4:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
    }
    .rate1:not(:checked) > label.notchecked,
    .rate2:not(:checked) > label.notchecked,
    .rate3:not(:checked) > label.notchecked,
    .rate4:not(:checked) > label.notchecked {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
    }
    .rate1:not(:checked) > label.checked,
    .rate2:not(:checked) > label.checked,
    .rate3:not(:checked) > label.checked,
    .rate4:not(:checked) > label.checked {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ffc700;
    }
    .rate1:not(:checked) > label:before,
    .rate2:not(:checked) > label:before,
    .rate3:not(:checked) > label:before,
    .rate4:not(:checked) > label:before {
    content: '★ ';
    }
    #olFoodList::-webkit-scrollbar {
    width: 12px; /* Adjust the width of the scrollbar */
    }

    #olFoodList::-webkit-scrollbar-thumb {
    background-color: #12476a !important ; /* Change the color of the thumb (the draggable part) */
    }

    #olFoodList::-webkit-scrollbar-track {
    margin-top: 35px;
    margin-bottom: 35px;
    }
    </style>
    <style>


    @media only screen and (max-width: 1500px){

    .shadow-owl::before{
        display: none;
        content:'';
        background: white !important;
        position: absolute;
        width: 1530px;
        height: 520px;
        right: -10px;
        top: 490px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        }
     @media only screen and (max-width: 1024px) {
    .shadow-owl::before{
        content:'';
        background: white !important;
        position: absolute;
        width: 1005px;
        height: 260px;
        right: 10px;
        top: 270px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        /*---ribbon--*/
        h1.ribbon {
        font-weight: normal;
        position: relative;
        background: rgb(9, 126, 194);
        width: 50%;
        color: white;
        text-align: center;
        padding: 10px 20px;
        margin: 20px auto 40px;
        text-transform: uppercase;
        border-radius: 2px;
        }
        h1.ribbon:before,
        h1.ribbon:after {
        content: "";
        position: absolute;
        top: -6px;
        border: 18px solid rgb(10, 112, 172);
        height: 20px;
        width: 250px;
        }
        h1.ribbon:before {
        left: -250px;
        border-right-width: 0px;
        border-left-color: transparent;
        }
        h1.ribbon:after {
        right: -250px;
        border-left-width: 0px;
        border-right-color: transparent;
        }
        h1.ribbon span:before,
        h1.ribbon span:after {
        content: "";
        position: absolute;
        border-style: solid;
        border-color: rgb(6, 82, 126) transparent transparent transparent;
        top: -6px;
        transform: rotate(180deg);
        }
        h1.ribbon span:before {
        left: 0;
        border-width: 6px 0 0 6px;
        }
        h1.ribbon span:after {
        right: 0;
        border-width: 6px 6px 0 0;
        }

     }


    @media only screen and (max-width: 768px) {
    .shadow-owl::before{
        content:'';
        background: white !important;
        position: absolute;
        width: 750px;
        height: 190px;
        right: 10px;
        top: 270px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }


        /*---ribbon--*/
        h1.ribbon {
        font-weight: normal;
        position: relative;
        background: rgb(9, 126, 194);
        width: 50%;
        color: white;
        text-align: center;
        padding: 10px 20px;
        margin: 20px auto 40px;
        text-transform: uppercase;
        border-radius: 2px;
        }
        h1.ribbon:before,
        h1.ribbon:after {
        content: "";
        position: absolute;
        top: -6px;
        border: 18px solid rgb(10, 112, 172);
        height: 20px;
        width: 160px;
        }
        h1.ribbon:before {
        left: -160px;
        border-right-width: 0px;
        border-left-color: transparent;
        }
        h1.ribbon:after {
        right: -160px;
        border-left-width: 0px;
        border-right-color: transparent;
        }
        h1.ribbon span:before,
        h1.ribbon span:after {
        content: "";
        position: absolute;
        border-style: solid;
        border-color: rgb(6, 82, 126) transparent transparent transparent;
        top: -6px;
        transform: rotate(180deg);
        }
        h1.ribbon span:before {
        left: 0;
        border-width: 6px 0 0 6px;
        }
        h1.ribbon span:after {
        right: 0;
        border-width: 6px 6px 0 0;
        }
    }

    .rate1:not(:checked) > label,
    .rate2:not(:checked) > label,
    .rate3:not(:checked) > label,
    .rate4:not(:checked) > label {
    font-size:20px;
    }
    .rate1:not(:checked) > label.notchecked,
    .rate2:not(:checked) > label.notchecked,
    .rate3:not(:checked) > label.notchecked,
    .rate4:not(:checked) > label.notchecked {
    font-size:20px;
    }
    .rate1:not(:checked) > label.checked,
    .rate2:not(:checked) > label.checked,
    .rate3:not(:checked) > label.checked,
    .rate4:not(:checked) > label.checked {
    font-size:20px;
    }

    @media only screen and (max-width: 425px) {
        .shadow-owl::before{
        content:'';
        background: white !important;
        position: absolute;
        width: 405px;
        height: 220px;
        right: 10px;
        top: 210px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        /*---ribbon--*/
        h1.ribbon {
        font-weight: normal;
        position: relative;
        background: rgb(9, 126, 194);
        width: 50%;
        color: white;
        text-align: center;
        padding: 5px 5px;
        margin: 5px auto 5px;
        text-transform: uppercase;
        border-radius: 2px;
        }
        h1.ribbon:before,
        h1.ribbon:after {
        content: "";
        position: absolute;
        top: -6px;
        border: 20px solid rgb(10, 112, 172);
        height: 10px;
        width: 100px;
        }
        h1.ribbon:before {
        left: -100px;
        border-right-width: 10px;
        border-left-color: transparent;
        }
        h1.ribbon:after {
        right: -100px;
        border-left-width: 10px;
        border-right-color: transparent;
        }
        h1.ribbon span:before,
        h1.ribbon span:after {
        content: "";
        position: absolute;
        border-style: solid;
        border-color: rgb(6, 82, 126); transparent transparent transparent;
        top: -6px;
        transform: rotate(180deg);
        }
        h1.ribbon span:before {
        left: 0;
        border-width: 6px 0 0 6px;
        }
        h1.ribbon span:after {
        right: 0;
        border-width: 6px 6px 0 0;
        }

    }

    @media only screen and (max-width: 375px) {
        .shadow-owl::before{
        content:'';
        background: white !important;
        position: absolute;
        width: 355px;
        height: 220px;
        right: 10px;
        top: 220px;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }

        /*---ribbon--*/
        h1.ribbon {
        font-weight: normal;
        position: relative;
        background: rgb(9, 126, 194);
        width: 100%;
        color: white;
        text-align: center;
        padding: 5px 5px;
        margin: 5px auto 5px;
        text-transform: uppercase;
        border-radius: 2px;
        }
        h1.ribbon:before,
        h1.ribbon:after {
        content: "";
        position: absolute;
        top: -6px;
        border: 15px solid rgb(10, 112, 172);
        height: 10px;
        width: 30px;
        }
        h1.ribbon:before {
        left: -30px;
        border-right-width: 10px;
        border-left-color: transparent;
        }
        h1.ribbon:after {
        right: -30px;
        border-left-width: 10px;
        border-right-color: transparent;
        }
        h1.ribbon span:before,
        h1.ribbon span:after {
        content: "";
        position: absolute;
        border-style: solid;
        border-color: rgb(6, 82, 126); transparent transparent transparent;
        top: -6px;
        transform: rotate(180deg);
        }
        h1.ribbon span:before {
        left: 0;
        border-width: 6px 0 0 6px;
        }
        h1.ribbon span:after {
        right: 0;
        border-width: 6px 6px 0 0;
        }
        .fc-header-toolbar.fc-toolbar{
            display: flex;
            justify-content: space-around;
            gap: 2px;
        }

        .fc-toolbar-title{
            font-size: 1.2rem !important;
        }
        .fc-toolbar-chunk{
            display: flex;
        }
    }
    </style>
</head>
<body>
    <div class="container mx-auto px-4">
        <nav class="bg-white flex flex-col md:flex-row items-center px-5 w-full xs:flex-row xxs:flex-row xs:items-center xs:justify-center xxs:items-center xxs:justify-center ">
            <a  href="/" class="flex items-center flex-none gap-2">
                <img class="xl:w-[250px] h-[120px] md:w-32 md:h-24 xs:h-24 xxs:h-24" src="{{ asset('images/logo.png') }}" alt="">
            </a>

            <div class="md:hidden mt-4">
                <!-- Mobile Menu Icon -->
                <button id="mobileMenuButton" class="text-gray-700 hover:text-gray-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>

            <ul class="text-lg items-center flex-auto justify-evenly text-slate-700 font-bold flex w-full md:w-auto md:flex md:px-2 xl:px-20 hidden">
                {{-- <li><a class="hover:border-b-4 border-blue-500 hover:text-blue-500 lg:text-xl xl:text-2xl md:text-sm" href="/">Home</a></li> --}}
                <li><a class="{{ Route::is('home.announcement*')?'border-b-4 text-blue-500' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.announcement.index') }}">Announcement</a></li>
                @if (!Route::is('home.bookings.show'))
                <li>
                    <a class="{{ Route::is('home.bookings*')?'border-b-4 text-sky-600 ' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.bookings.index') }}">Bookings</a>
                    {{-- <a class="{{ Route::is('home.bookings*')?'border-b-4 text-sky-600 ' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.bookings.index') }}">Bookings</a> --}}
                </li>
                @endif
                <li><a class="{{ Route::is('home.location*')?'border-b-4 text-sky-600 ' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.location.index') }}">Location</a></li>
                <li><a class="{{ Route::is('home.contact*')?'border-b-4 text-sky-700 ' : '' }} hover:border-b-4 border-sky-700 hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.contact.index') }}">Contact</a></li>
                @if (Auth::check())
                    @if (Auth::user()->role=='user')
                    <li>
                        <a id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-blue-500 cursor-pointer hover:text-blue-800 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 lg:text-xl xl:text-2xl md:text-sm" type="button">Account<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                          </svg>
                          @if (Auth::user()->messagesCount>0)

                          <span class="flex m-2 items-center justify-center" style="border-radius:50%;font-size:15px; height:20px; width:20px; background:green; color:white !important;">
                            <span>
                                {{ Auth::user()->messagesCount }}
                            </span>
                            </span>
                         @endif
                        </a>

                        <!-- Dropdown menu -->
                        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                              <li>
                                {{-- <a href="{{ route('home.booked.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Booking</a> --}}
                                <a href="{{ route('home.bookings.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Bookings</a>
                            </li>
                              <li>
                                <a href="{{ route('home.history.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">History</a>
                              </li>

                              <li class="flex flex-row items-center justify-start">
                                <a href="{{ route('home.message.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Message</a>
                                @if (Auth::user()->messagesCount>0)
                                <span class="flex items-center justify-center" style="border-radius:50%;font-size:15px; height:20px; width:20px; background:green; color:white !important;">
                                    <span>
                                        {{ Auth::user()->messagesCount }}
                                    </span>
                                    </span>
                                    @endif
                                </li>

                              <li>
                                <a href="{{ route('guest.logout') }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Sign out</a>
                              </li>
                            </ul>
                        </div>
                    </li>
                    @if (Route::is('home.bookings.show'))
                    <li><a class="{{ Route::is('home.location*')?'border-b-4 text-blue-500' : '' }}  hover:bg-sky-700 bg-sky-600 py-2 px-3 rounded-md text-white lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.bookings.index') }}">Book Now</a></li>
                    @endif
                    @elseif(Auth::user()->role=='admin')
                    <li>
                        <a id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-blue-500 cursor-pointer hover:text-blue-800 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 lg:text-xl xl:text-2xl md:text-sm" type="button">Account<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                          </svg>
                        </a>
                        <!-- Dropdown menu -->
                        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                              <li>
                                {{-- <a href="{{ route('home.booked.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Booking</a> --}}
                                <a href="{{ route('admin.dashboard.index') }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Dashboard</a>
                            </li>
                                <a href="{{ route('guest.logout') }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Sign out</a>
                              </li>
                            </ul>
                        </div>
                    </li>
                    @elseif(Auth::user()->role=='employee')
                    <li>
                        <a id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-blue-500 cursor-pointer hover:text-blue-800 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 lg:text-xl xl:text-2xl md:text-sm" type="button">Account<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                          </svg>
                        </a>
                        <!-- Dropdown menu -->
                        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                              <li>
                                {{-- <a href="{{ route('home.booked.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Booking</a> --}}
                                <a href="{{ route('employee.dashboard.index') }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Dashboard</a>
                            </li>
                                <a href="{{ route('guest.logout') }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Sign out</a>
                              </li>
                            </ul>
                        </div>
                    </li>
                    @endif
                @else

                <li><a class="{{ Route::is('guest*')?'border-b-4 text-sky-700' : '' }} hover:border-b-4  border-sky-700 hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('guest.index') }}">Login</a></li>
                @endif
                @if (Route::is('home.bookings.*'))

                @else
                    <li><a class="{{ Route::is('home.location*')?'border-b-4 text-blue-500' : '' }}  hover:bg-sky-700 bg-sky-600 py-2 px-3 rounded-md text-white lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.bookings.index') }}">Book Now</a></li>
                @endif
            </ul>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden bg-white divide-y divide-gray-100 rounded-lg shadow mt-2 hidden">
            <ul class="py-2 text-sm text-gray-700" aria-labelledby="mobileMenuButton">
                {{-- <li><a class="hover:border-b-4 border-blue-500 hover:text-blue-500 lg:text-xl xl:text-2xl md:text-sm" href="/">Home</a></li> --}}
                <li><a class="{{ Route::is('home.announcement*')?'border-b-4 text-blue-500' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.announcement.index') }}">Announcement</a></li>
                <li><a class="{{ Route::is('home.bookings*')?'border-b-4 text-sky-600 ' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.bookings.index') }}">Bookings</a></li>
                <li><a class="{{ Route::is('home.location*')?'border-b-4 text-sky-600 ' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.location.index') }}">Location</a></li>
                @if (Auth::check())
                <li>
                    <a id="dropdownDefaultButtons" data-dropdown-toggle="dropdowns" class="text-blue-500 cursor-pointer hover:text-blue-800 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 lg:text-xl xl:text-2xl md:text-sm" type="button">My Account<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                      </svg>
                    </a>

                    <!-- Dropdown menu -->
                    <div id="dropdowns" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButtons">
                          <li>
                            {{-- <a href="{{ route('home.booked.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Book</a> --}}
                            <a href="{{ route('home.bookings.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Bookings</a>
                          </li>
                          <li>
                            <a href="{{ route('home.history.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">History</a>
                          </li>
                          <li class="flex flex-row items-center justify-start">
                            <a href="{{ route('home.message.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Message</a>
                            @if (Auth::user()->messagesCount>0)
                            <span class="flex items-center justify-center" style="border-radius:50%;font-size:15px; height:20px; width:20px; background:green; color:white !important;">
                                <span>
                                    {{ Auth::user()->messagesCount }}
                                </span>
                                </span>
                                @endif
                            </li>
                          <li>
                            <a href="{{ route('guest.logout') }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Sign out</a>
                          </li>
                        </ul>
                    </div>
                </li>
                @else
                <li><a class="{{ Route::is('home.contact*')?'border-b-4 text-sky-700 ' : '' }} hover:border-b-4 border-sky-700 hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.contact.index') }}">Contact</a></li>
                <li><a class="{{ Route::is('guest*')?'border-b-4 text-sky-700' : '' }} hover:border-b-4  border-sky-700 hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('guest.index') }}">Login</a></li>
                @endif
                @if (Route::is('home.bookings.*'))

                @else
                    <li><a class="{{ Route::is('home.location*')?'border-b-4 text-blue-500' : '' }}  hover:bg-sky-700 bg-sky-600 py-2 px-3 rounded-md text-white lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.bookings.index') }}">Book Now</a></li>
                @endif
            </ul>
        </div>

        {{-- <nav class="bg-white flex px-5 w-full">
            <div class="flex items-center flex-none gap-2">
                <img class="xl:w-[250px] h-[120px] xl:md:w-32 md:h-24" src="{{ asset('images/logo.png') }}" alt="">
            </div>
            <ul class="text-lg items-center flex-auto justify-evenly text-slate-700 font-bold flex  w-full md:px-2 xl:px-20">
                <li><a class="hover:border-b-4 border-blue-500 hover:text-blue-500 lg:text-xl xl:text-2xl md:text-sm" href="/">Home</a></li>
                <li><a class="{{ Route::is('home.announcement*')?'border-b-4 text-blue-500' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.announcement.index') }}">Announce</a></li>
                <li><a class="{{ Route::is('home.bookings*')?'border-b-4 text-sky-600 ' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.bookings.index') }}">Bookings</a></li>
                <li><a class="{{ Route::is('home.location*')?'border-b-4 text-sky-600 ' : '' }} hover:border-b-4 border-sky-600  hover:text-sky-600 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.location.index') }}">Location</a></li>
                @if (Auth::check())
                <li>
                    <a id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-blue-500 cursor-pointer hover:text-blue-800 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 lg:text-xl xl:text-2xl md:text-sm" type="button">My Account<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                      </svg>
                    </a>

                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                          <li>
                            <a href="{{ route('home.booked.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">My Book</a>
                          </li>
                          <li>
                            <a href="{{ route('home.history.show',Auth::id()) }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Book History</a>
                          </li>
                          <li>
                            <a href="{{ route('guest.logout') }}" class="block px-4 py-2 text-slate-700  hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm">Sign out</a>
                          </li>
                        </ul>
                    </div>
                </li>
                @else
                <li><a class="{{ Route::is('home.contact*')?'border-b-4 text-sky-700 ' : '' }} hover:border-b-4 border-sky-700 hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.contact.index') }}">Contact</a></li>
                <li><a class="{{ Route::is('guest*')?'border-b-4 text-sky-700' : '' }} hover:border-b-4  border-sky-700 hover:text-sky-700 lg:text-xl xl:text-2xl md:text-sm" href="{{ route('guest.index') }}">Login</a></li>
                @endif
                @if (Route::is('home.bookings.*'))

                @else
                    <li><a class="{{ Route::is('home.location*')?'border-b-4 text-blue-500' : '' }}  hover:bg-sky-700 bg-sky-600 py-2 px-3 rounded-md text-white lg:text-xl xl:text-2xl md:text-sm" href="{{ route('home.bookings.index') }}">Book Now</a></li>
                @endif

            </ul>
        </nav> --}}
      <!--code-->
      @yield('content')
      <!--end code-->

      <footer id="contactLists" class="mt-10 pt-10 mb-5 flex-col">
        <div class="xl:gap-6 md:gap-2 xs:gap-2 text-slate-800 text-2xl h-full w-full flex lg:flex-row justify-around xs:flex-col xxs:flex-col xs:items-center">
            <div class="py-3 flex flex-col gap-y-2 xs:text-sm xxs:text-sm">
                <h1 class="font-bold xl:text-2xl md:text-sm">POOL HOURS</h1>
                <ul class="flex flex-col gap-y-1 xl:text-xl  md:text-sm">
                    <li class="text-slate-950 font-bold xl:text-lg">Tues & Thurs:</li>
                    <li> 9am - 3pm and 4pm-7:30pm</li>
                    <li> <span class="text-slate-950 font-bold"> Wed & Fri </span> : 8:30am - 3pm</li>
                    <li> <span class="text-slate-950 font-bold"> Sat </span> : 7:45am - 1pm</li>
                    <li> <span class="text-slate-950 font-bold">Sun & Mon </span> : Closed</li>
                </ul>
            </div>

            <div class="py-3 flex items-center flex-col gap-5 xs:text-sm xxs:text-sm">
                <h1 class="font-bold uppercase">Social Accounts</h1>
                <ul class="flex justify-around flex-row gap-5">
                    <li><a class="hover:text-slate-950" href=""><i style="color:#4267B2;" class="mr-1 text-6xl fa-brands fa-facebook"></i></a></li>
                    <li><a class="hover:text-slate-950" href=""><i class="mr-1 text-5xl fa-brands fa-instagram" style="border-radius:10px; padding:7px; background: radial-gradient(circle farthest-corner at 35% 90%, #fec564, transparent 50%), radial-gradient(circle farthest-corner at 0 140%, #fec564, transparent 50%), radial-gradient(ellipse farthest-corner at 0 -25%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 20% -50%, #5258cf, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 0, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 60% -20%, #893dc2, transparent 50%), radial-gradient(ellipse farthest-corner at 100% 100%, #d9317a, transparent), linear-gradient(#6559ca, #bc318f 30%, #e33f5f 50%, #f77638 70%, #fec66d 100%); color:white;"></i></a></li>
                    <li><a class="hover:text-slate-950" href=""><i class="mr-1 text-4xl fa-brands fa-tiktok" style="color:white; background: black; padding:10px; border-radius:10px;"></i></a></li>
                </ul>
                <div class="pb-3"><i class="fa-regular fa-copyright"></i>  {{ date('Y') }} <b class=" text-slate-950">Maramag. Bukidnon Mindanao.</b> All Rights Reserved.</div>
            </div>

            <div class="py-3 flex flex-col gap-y-2 xs:text-sm xxs:text-sm">
                <h1 class="font-bold uppercase xl:text-2xl md:text-sm ">Pool Address</h1>
                <ul class="flex flex-col gap-y-1 xl:text-xl  md:text-sm">
                    <li>6801 Long Beach Blvd.</li>
                    <li>Long Beach, Mindanao 90805</li>
                    <li>Phone: +639 193 499 313</li>
                    <li>Lanline 555 333 11</li>
                </ul>
            </div>

        </div>
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.owl-carousel').owlCarousel({
        center: true,
        items:3,
        loop:true,
        margin:30,
        nav:false,
        dots:true,
        autoplay: true,
        slideTransition: 'linear',
        autoplayTimeout: 5000,
        autoplaySpeed: 6000,
        autoplayHoverPause: false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });
</script>
<script>
    // document.querySelector('#scrollToEvents').addEventListener('click',(event)=>{
    //     event.preventDefault();
    //     document.querySelector('#eventLists').
    //     scrollIntoView({ behavior: 'smooth', block: 'end', inline: 'nearest' })
    // })
    // document.querySelector('#scrollToGallery').addEventListener('click',(event)=>{
    //     event.preventDefault();
    //     document.querySelector('#eventGallery').
    //     scrollIntoView({ behavior: 'smooth', block: 'end', inline: 'nearest' })
    // })
    // document.querySelector('#scrollToContact').addEventListener('click',(event)=>{
    //     event.preventDefault();
    //     document.querySelector('#contactLists').
    //     scrollIntoView({ behavior: 'smooth', block: 'end'})
    // })
</script>
<script>
    // JavaScript to toggle mobile menu visibility
    document.getElementById('mobileMenuButton').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
</script>
</body>
</html>
