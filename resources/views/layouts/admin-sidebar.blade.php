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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    



    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
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
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-primary">
                <div class="d-flex sidebar flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    {{-- <hr class="align-middle fs-5 mb-1 text-white px-3"> --}}
                    <a href="{{route('admin.home')}}" class="d-flex align-items-center pb-4 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Centralized Barangay Information System</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="{{route('admin.home')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="home">
                                <i class="bi-house-fill" id="homeIcon"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item has-submenu">
                            <button class="nav-link align-middle fs-5 mb-1 text-white px-3" id="barangay" href=""><i class="bi-pin-map-fill"></i> 
                                <span class="ms-1 d-none d-sm-inline sub-menu">Barangay</span>
                            </button>
                            <ul class="submenu list-unstyled">
                                
                                <li style="margin-left: 1.75rem">
                                    <a class="nav-link text-white" href="{{route('barangay')}}" id="brgy">
                                        <i class="bi-geo-alt-fill"></i>  Barangays
                                    </a>
                                </li>
                                <li style="margin-left: 1.75rem">
                                    <a class="nav-link text-white" href="{{route('account')}}" id="acct">
                                        <i class="bi-person-square"></i>  Accounts
                                    </a>
                                </li>
                                <li style="margin-left: 1.75rem">
                                    <a class="nav-link text-white" href="{{route('admin.resident')}}" id="resident">
                                        <i class="bi-people-fill"></i>  Residents
                                    </a>
                                </li>
                            </ul>
                            
                            {{-- <a href="{{route('barangay')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="brgy">
                                <i class="bi-bank2" id="brgyIcon"></i>  <span class="ms-1 d-none d-sm-inline">Barangay</span>
                            </a> --}}
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{route('account')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3" id="acct">
                                <i class="bi-person-circle" id="acctIcon"></i>  <span class="ms-1 d-none d-sm-inline">Accounts</span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="{{route('admin.resident')}}" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                <i class="bi-people-fill"></i>  <span class="ms-1 d-none d-sm-inline">Residents</span>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                <i class="bi-calendar-event-fill"></i>  <span class="ms-1 d-none d-sm-inline">Blotters</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link align-middle fs-5 mb-1 text-white px-3">
                                <i class="bi-journal-text"></i>  <span class="ms-1 d-none d-sm-inline">Reports</span>
                            </a>
                        </li>
                        <li class="nav-item has-submenu">
                            <button class="nav-link align-middle fs-5 mb-1 text-white px-3" id="settings" href=""><i class="bi-wrench"></i>
                                <span class="ms-1 d-none d-sm-inline sub-menu">Settings</span>
                            </button>
                            
                            <ul class="submenu list-unstyled">
                                <li style="margin-left: 1.75rem">
                                    <hr class="align-middle fs-5 mb-1 text-white px-3">
                                    <a class="nav-link text-white" href="#" id="logo">
                                        <i class="bi-gear-fill"></i> Profile
                                    </a>
                                </li>
                                <li style="margin-left: 1.75rem">
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
            <div class="col" style="width: 0%;">
              @yield('content')
            </div>
        </div>
    </div>

<script>
// document.addEventListener("DOMContentLoaded", function(){
//   document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
    
//     element.addEventListener('click', function (e) {

//       let nextEl = element.nextElementSibling;
//       let parentEl  = element.parentElement;	

//         if(nextEl) {
//             e.preventDefault();	
//             let mycollapse = new bootstrap.Collapse(nextEl);
            
//             if(nextEl.classList.contains('show')){
//               mycollapse.hide();
//             } else {
//                 mycollapse.show();
//                 // find other submenus with class=show
//                 var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
//                 // if it exists, then close all of them
//                 // if(opened_submenu){
//                 //   new bootstrap.Collapse(opened_submenu);
//                 // }
//             }
//         }
//     }); // addEventListener
//   }) // forEach
// }); 
</script>
</body>
</html>
