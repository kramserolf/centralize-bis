<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Centralized Barangay Information System</title>

    <link rel="icon" href="{{ url('images/baggao_logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    



    <!-- Scripts -->

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>



</head>
<body>


     
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="/" class="d-flex align-items-center pb-4 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline">Centralized Barangay Information System</span>
                        </a>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="{{route('admin.home')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="home">
                                    <i class="bi-house-fill" id="homeIcon"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('barangay')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="brgy">
                                    <i class="bi-bank2" id="brgyIcon"></i>  <span class="ms-1 d-none d-sm-inline">Barangay</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('account')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="acct">
                                    <i class="bi-person-circle" id="acctIcon"></i>  <span class="ms-1 d-none d-sm-inline">Accounts</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                    <i class="bi-people-fill"></i>  <span class="ms-1 d-none d-sm-inline">Residents</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                    <i class="bi-archive-fill"></i>  <span class="ms-1 d-none d-sm-inline">Reports</span>
                                </a>
                            </li>
                        </ul>
                        <hr>
                        <div class="dropdown pb-4">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- <img src="https://github.com/mdo.png" alt="hugenerd" width="40" height="40" class="rounded-circle"> --}}
                                <span class="d-none d-sm-inline mx-4">
                                    @if(Auth::check())
                                        {{Auth::user()->name}}
                                    @endif
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Sign out') }}
                                    </a>
                                    <form id='logout-form' action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col" style="width: 0%;">
                  @yield('content')
                </div>
            </div>
        </div>
</body>
</html>
