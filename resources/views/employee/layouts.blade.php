<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
<title>Pool Reservation</title>
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">
<!-- Vendors styles-->
<link rel="stylesheet" href="{{ asset('vendors/simplebar/css/simplebar.css') }}">
<link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
<!-- Main styles for this application-->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('css/examples.css') }}">

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.js"></script>


<link href="https://cdn.jsdelivr.net/npm/flowbite@2.2.0/dist/flowbite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.2.0/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--     <link href="vendors/@coreui/chartjs/css/coreui-chartjs.css" rel="stylesheet"> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@vite('resources/css/app.css')
</head>
<body>
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-item">
        <a href="{{ route('employee.dashboard.index') }}" class="nav-link" href="index.html">
        Dashboard
        {{-- <span class="badge badge-sm bg-info ms-auto">NEW</span> --}}
    </a></li>
    <li class="nav-item">
        <a href="{{ route('employee.history.index') }}" class="nav-link" href="index.html">
         History
        {{-- <span class="badge badge-sm bg-info ms-auto">NEW</span> --}}
    </a></li>
    {{-- <li class="nav-item border-b-2 border-slate-600">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
        Manager User
    </a>
    </li>
    <li class="border-b-2 border-slate-600">
        <a class="nav-link" href="#">
        Income Report
    </a>
    </li>
    <li class="border-b-2 border-slate-600">
    <a class="nav-link" href="{{ route('admin.bookreport.index') }}">
        Booking Report</a>
    </li>
    <li class="border-b-2 border-slate-600">
    <a class="nav-link" href="{{ route('admin.employee.index') }}">
        Manage Employee</a>
    </li>
    <li class="border-b-2 border-slate-600">
    <a class="nav-link" href="{{ route('admin.bookings.index') }}">
        Manage Booking</a>
    </li>
    <li class="border-b-2 border-slate-600">
    <a class="nav-link" href="{{ route('admin.rating.index') }}">
        Manage Feedback</a>
    </li>
    <li class="border-b-2 border-slate-600">
    <a class="nav-link" href="{{ route('admin.availity.index') }}">
        Manage Resort Date</a>
    </li> --}}

    <li class="border-b-2 border-slate-600">
        <a class="nav-link" href="{{ route('guest.logout') }}">
      Sign Out</a>
    </li>
    </ul>
    <button class="sidebar-toggler" type="button" onclick="hideToggler()" data-coreui-toggle="unfoldable"></button>
    <script>
           function hideToggler(event){
            let sideBar = document.querySelector('#sidebar')
            sideBar.classList.toggle("sidebar-toggler");
        }
    </script>
</div>
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    <header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
        <svg class="icon icon-lg">
        </svg>
        </button><a class="header-brand d-md-none" href="#">
        <ul class="header-nav d-none d-md-flex">
        {{-- <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Settings</a></li> --}}
        </ul>
        <ul class="header-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
            </svg></a></li>
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
            </svg></a></li>
        <li class="nav-item"><a class="nav-link" href="#">
            <svg class="icon icon-lg">
            </svg></a></li>
        </ul>

    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
        {{-- <ol class="breadcrumb my-0 ms-2">
            <li class="breadcrumb-item">
             <span>Home</span>
            </li>
            <li class="breadcrumb-item active"><span>Dashboard</span></li>
        </ol> --}}
        </nav>
    </div>
    </header>
    <div class="body flex-grow-1 px-3">
         @yield('content')
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src={{ asset('vendors/simplebar/js/simplebar.min.js') }}></script>
    <!-- Plugins and scripts required by this view-->
    <!-- <script src="vendors/chart.js/js/chart.min.js"></script>-->
    {{-- <script src="vendors/@coreui/chartjs/js/coreui-chartjs.js"></script> --}}
    {{-- <script src="vendors/@coreui/utils/js/coreui-utils.js"></script> --}}
    {{-- <script src="js/main.js"></script> --}}
  </body>
</html>
