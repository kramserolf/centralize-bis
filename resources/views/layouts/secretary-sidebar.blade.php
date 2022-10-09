<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Centralized Barangay Information System</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">



    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>    --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>    
    

    <style>
        .sub-menu{
            color: 	#C0C0C0;
        }

        @media (max-width: 568px) {
            .h-sm-100 {
                height: 100%;
            }
            .sticky-top {
                height: 8%;
            }
            #household{
                width: 10x;
            }
        }

        @media (min-width: 768px) {
            .sticky-top {
                height: 100vh;
        }
        }

    </style>
</head>
<body>
    <div class="container-fluid overflow-hidden">
        <div class="row vh-100 overflow-auto">
            <div class="col-12 col-sm-3 col-xl-2 col-sm-1 px-sm-2 px-0 bg-primary d-flex sticky-top sticky">
                <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                    <a href="" class="mx-auto d-block d-flex align-items-center fs-5 pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        Barangay @if(!empty($filter_setting->barangay))
                        {{$filter_setting->barangay}}
                        @else
                        Name
                        @endif
                    </a>
                    <a href="/" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        {{-- <span class="fs-5">B<span class="d-none d-sm-inline">rand</span></span> --}}
                        @if(!empty($filter_setting->logo))
                        <img class="mx-auto d-block d-none d-sm-inline" src="{{asset('images/barangay_logo/'.$filter_setting->logo.'')}}" alt="Your Barangay Logo here" style="width: 40%">
                        @else
                        <img class="mx-auto d-block d-none d-sm-inline" src="{{asset('images/baggao_logo.png')}}" alt="Your Barangay Logo here" style="width: 40%;">
                        @endif
                    </a>
                        <ul class="nav nav-pills fs-5 flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto justify-content-center align-items-center align-items-sm-start px-2 fs-5" id="menu">
                        <li class="nav-item" id="home">
                            <a href="{{route('secretary.home')}}" class="nav-link px-sm-0 px-2 text-white">
                                <i class="bi-house-door-fill sidebar-home"></i> <span class="ms-1 d-none d-sm-inline sidebar-home">Dashboard</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-sm-0 px-2 text-white">
                                <i class="fs-5 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-sm-0 px-2 text-white">
                                <i class="fs-5 bi-table"></i> <span class="ms-1 d-none d-sm-inline ">Orders</span></a>
                        </li> --}}
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-white " id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-geo-alt sidebar-brgy"></i> <span class="ms-1 d-none d-sm-inline sidebar-brgy">Barangay</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="{{route('resident')}}"><i class="bi-people-fill"></i> Residents</a></li>
                                <li><a class="dropdown-item" href="{{route('household')}}"><i class="bi-pin-map-fill sidebar-brgy"></i> Households</a></li>
                                <li><a class="dropdown-item" href="{{route('barangay.officials')}}"><i class="bi-person-badge-fill"></i> Barangay Officials</a></li>
                                <li><a class="dropdown-item" href="{{route('barangay.zone')}}"><i class="bi-compass-fill"></i> Zone</a></li>
                                
                                {{-- <li><a class="dropdown-item" href="{route('barangay.blotter')}}"><i class="bi-record-btn-fill"></i> Blotters</a></li> --}}
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-white" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-journal-text sidebar-issuance"></i></i> <span class="ms-1 d-none d-sm-inline sidebar-issuance">Issuance</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href=""><i class="bi-record-btn-fill"></i>     Blotters</a></li>
                                <li><a class="dropdown-item" href=""><i class="bi-file-earmark-pdf-fill"></i> Certificates</a></li>
                                <li><a class="dropdown-item" href=""><i class="bi-file-earmark-word-fill"></i> Clearance</a></li>
                                {{-- <li><a class="dropdown-item" href="{route('barangay.blotter')}}"><i class="bi-record-btn-fill"></i> Zone</a></li> --}}
                                
                                {{-- <li><a class="dropdown-item" href="{route('barangay.blotter')}}"><i class="bi-record-btn-fill"></i> Blotters</a></li> --}}
                            </ul>
                        </li>
                        {{-- <li>
                            <a href="#" class="nav-link px-sm-0 px-2 text-white">
                                <i class="bi-journal-text"></i> <span class="ms-1 d-none d-sm-inline ">Issuance</span></a>
                        </li> --}}
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-white" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-newspaper sidebar-reports"></i> <span class="ms-1 d-none d-sm-inline sidebar-reports">Reports</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="{{route('resident')}}"><i class="bi-people-fill"></i> List of Residents</a></li>
                                <li><a class="dropdown-item" href=""><i class="bi-file-earmark-pdf-fill"></i> List of Household</a></li>
                                <li><a class="dropdown-item" href="{{route('senior')}}"><i class="bi-file-earmark-word-fill"></i> List of Senior Citizen</a></li>
                                {{-- <li><a class="dropdown-item" href="{route('barangay.blotter')}}"><i class="bi-record-btn-fill"></i> Zone</a></li> --}}
                                
                                {{-- <li><a class="dropdown-item" href="{route('barangay.blotter')}}"><i class="bi-record-btn-fill"></i> Blotters</a></li> --}}
                            </ul>
                        </li>
                        {{-- <li>
                            <a href="#" class="nav-link px-sm-0 px-2 text-white">
                                <i class="bi-newspaper"></i> <span class="ms-1 d-none d-sm-inline ">Reports</span></a>
                        </li> --}}
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-white" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-wrench sidebar-settings"></i> <span class="ms-1 d-none d-sm-inline sidebar-settings">Settings</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li>
                                    <a class="dropdown-item" href="/barangay/settings">
                                        <i class="bi-person-badge-fill"></i>
                                        Logo
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/barangay/layouts">
                                        <i class="bi-person-badge-fill"></i>
                                        Layouts
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
                                        <i class="bi-person-badge-fill"></i>
                                        Barangay
                                    </a>
                                </li>
                                {{-- <li><a class="dropdown-item" href="{{route('resident')}}"><i class="bi-people-fill"></i> Residents</a></li>
                                <li><a class="dropdown-item" href="{route('barangay.blotter')}}"><i class="bi-record-btn-fill"></i> Blotters</a></li> --}}
                            </ul>
                        </li>
                    </ul>
                    <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="28" height="28" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">
                                @auth
                                    {{Auth::user()->name}}
                                @endauth
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    Sign out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- logout modal --}}
            <div class="modal fade text-black" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Select "Logout" below if you want to end your current session.
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-link" type="button" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end of logut modal --}}
            <div class="col d-flex flex-column h-sm-100">
                <main class="row overflow-auto">
                    <div class="col pt-4 h-100">
                       @yield('content')
                    </div>
                </main>
                {{-- <footer class="row bg-light py-4 mt-auto">
                    <div class="col"> Footer content here... </div>
                </footer> --}}
            </div>
        </div>
    </div>
<script>
</script>
</body>
</html>
