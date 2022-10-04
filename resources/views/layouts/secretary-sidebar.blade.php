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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    

    <style>
        .sub-menu{
            color: 	#C0C0C0;
        }
    </style>
</head>
<body>


     
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="col-auto col-sm-3 col-lg-2 px-0 bg-primary">
                    <div class="d-flex sidebar flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <div class="col-md-4 col-lg-12 mb-3">
                            <a href="{{route('secretary.home')}}" class="pb-3 text-white text-decoration-none">
                                @if(!empty($filter_setting->logo))
                                <img class=" mx-auto d-block" src="{{asset('images/barangay_logo/'.$filter_setting->logo.'')}}" alt="Your Barangay Logo here" style="width: 50%">
                                @else
                                <img class="mx-auto d-block" src="{{asset('images/baggao_logo.png')}}" alt="Your Barangay Logo here" style="width: 50%;">
                                @endif
                            </a>
                        </div>
                       
          
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="{{route('secretary.home')}}" class="nav-link align-middle fs-5 mb-1 text-white px-1" id="home">
                                    <i class="bi-house-fill" id="homeIcon"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item has-submenu">
                                <button class="nav-link align-middle fs-5 mb-1 text-white px-1" id="barangay" href=""><i class="bi-pin-map-fill"></i>
                                    <span class="ms-1 d-none d-sm-inline sub-menu">Barangay</span>
                                </button>
                                <ul class="submenu list-unstyled">
                                    
                                    <li style="margin-left: 0.5rem">
                                        <a class="nav-link text-white" href="{{route('barangay.officials')}}" id="brgy_officials">
                                            <i class="bi-person-badge-fill"></i> Barangay Officials
                                        </a>
                                    </li>
                                    <li style="margin-left: 0.5rem">
                                        <a class="nav-link text-white" href="{{route('resident')}}" id="residents">
                                            <i class="bi-people-fill"></i>  Residents
                                        </a>
                                    </li>
                                    <li style="margin-left: 0.5rem">
                                        <a class="nav-link text-white" href="{{route('barangay.blotter')}}" id="blotters">
                                            <i class="bi-record-btn-fill"></i>  Blotters
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{route('barangay.officials')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="officials">
                                    <i class="bi-people-fill" id="officialsIcon"></i> <span class="ms-1 d-none d-sm-inline">Barangay Officials</span>
                                </a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a href="{{route('resident')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="residents">
                                    <i class="bi-person-lines-fill" id="residents"></i>  <span class="ms-1 d-none d-sm-inline">Residents</span>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="#" class="nav-link align-middle fs-5 mb-1 text-white px-1" id="files">
                                    <i class="bi-journal-text"></i>  <span class="ms-1 d-none d-sm-inline">Issuance</span>
                                </a>
                            </li>
                            <li class="nav-item has-submenu">
                                <button class="nav-link align-middle fs-5 mb-1 text-white px-1" id="settings" href=""><i class="bi-wrench"></i>
                                    <span class="ms-1 d-none d-sm-inline sub-menu">Settings</span>
                                </button>
                                
                                <ul class="submenu list-unstyled">
                                    <li style="margin-left: 0.5rem">
                                        <a class="nav-link text-white" href="{{route('setting')}}" id="brgySetting">
                                            <i class="bi-gear-fill"></i> @if(!empty($filter_setting->barangay))
                                                {{$filter_setting->barangay}}
                                                @else
                                                Barangay
                                                @endif
                                        </a>
                                    </li>
                                    <li style="margin-left: 0.5rem">
                                        <a class="nav-link text-white" href="#" id="logo">
                                            <i class="bi-person-badge"></i> Profile
                                        </a>
                                    </li>
                                    <li style="margin-left: 0.5rem">
                                        <a type="button" class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                            <i class="bi-exclamation-diamond-fill"></i> Sign out
                                        </a>
                                    </li>
                                </ul>
                                
                                {{-- <a href="{{route('barangay')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="brgy">
                                    <i class="bi-bank2" id="brgyIcon"></i>  <span class="ms-1 d-none d-sm-inline">Barangay</span>
                                </a> --}}
                            </li>
                        </ul>
                        <hr>
                                            <!-- Logout Modal-->
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
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none ">
                            {{-- <img src="https://github.com/mdo.png" alt="hugenerd" width="40" height="40" class="rounded-circle"> --}}
                            
                            <span class="badge bg-success fs-5 d-none d-sm-inline">
                                @if(Auth::check())
                                <i class="bi-person-circle"></i> {{Auth::user()->name}}
                                @endif
                            </span>
                        </a>
                    </div>
                    </div>
                </div>
                <div class="col py-3">
                  @yield('content')
                </div>
            </div>
        </div>
<script>
</script>
</body>
</html>
