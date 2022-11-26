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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.html5.min.js"></script>
    <script src="{{ asset('js/button.print.js') }}"></script>
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.3/js/buttons.print.min.js"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    

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

    .overlay {
          display: none;
          position: fixed;
          width: 100%;
          height: 100%;
          top: 0;
          left: 0;
          z-index: 999;
          background: rgba(255, 255, 255, 0.8) url({{ asset('images/loading.gif') }}) center no-repeat;
      }

      /* Turn off scrollbar when body element has the loading class */
      body.loading {
          overflow: hidden;
      }

      /* Make spinner image visible when body element has the loading class */
      body.loading .overlay {
          display: block;
      }
    </style>
</head>
<body>
    {{-- <div class="container-fluid overflow-hidden">
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

                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-white " id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-geo-alt sidebar-brgy"></i> <span class="ms-1 d-none d-sm-inline sidebar-brgy">Barangay</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="{{route('resident')}}"><i class="bi-people-fill"></i> Residents</a></li>
                                <li><a class="dropdown-item" href="{{route('barangay.resident_account')}}"><i class="bi-key-fill"></i> Resident Accounts</a></li>
                              
                                <li><a class="dropdown-item" href="{{route('barangay.officials')}}"><i class="bi-person-badge-fill"></i> Barangay Officials</a></li>
                                <li><a class="dropdown-item" href="{{route('barangay.zone')}}"><i class="bi-compass-fill"></i> Zone</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">

                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-white" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-journal-text sidebar-issuance"></i></i> <span class="ms-1 d-none d-sm-inline sidebar-issuance">Issuance</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="{{ route('barangay.blotter') }}"><i class="bi-record-btn-fill"></i>     Blotters</a></li>
                                <li><a class="dropdown-item" href="{{route('get-certificate.layout')}}"><i class="bi-file-earmark-pdf-fill"></i> Certificates</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-white" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-newspaper sidebar-reports"></i> <span class="ms-1 d-none d-sm-inline sidebar-reports">Reports</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="{{ route('resident.per-zone') }}"><i class="bi-people-fill"></i> List of Residents <span class="text-muted" style="font-size: 12px">(per zone)</span></a></li>
                                <li><a class="dropdown-item" href="{{route('household')}}"><i class="bi-pin-map-fill sidebar-brgy"></i> List of Household</a></li>
                                <li><a class="dropdown-item" href="{{route('senior')}}"><i class="bi-file-earmark-word-fill"></i> List of Senior Citizen</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('barangay.announcement')}}" class="nav-link px-sm-0 px-2 text-white">
                                <i class="bi-megaphone-fill sidebar-announcement"></i> <span class="ms-1 d-none d-sm-inline sidebar-announcement">Announcements</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-white" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-wrench sidebar-settings"></i> <span class="ms-1 d-none d-sm-inline sidebar-settings">Settings</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="/barangay/settings"><i class="bi-person-badge-fill"></i> Barangay</a></li>
                                <li><a class="dropdown-item" href="/barangay/certificate-types"><i class="bi-person-badge-fill"></i> Certificate Types</a></li>
                                <li><a class="dropdown-item" href="/barangay/certificate-layouts"><i class="bi-person-badge-fill"></i> Certificate Layouts</a></li>
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

            <div class="col d-flex flex-column h-sm-100">
                <main class="row overflow-auto">
                    <div class="col pt-4 h-100">
                       @yield('content')
                    </div>
                </main>

            </div>
        </div>
    </div> --}}
        <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebar bg-primary sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="{{ route('secretary.home') }}" class="mx-auto d-block d-flex align-items-center fs-5 pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span id="brgy_name" >
                            Barangay @if(!empty($filter_setting->barangay))
                        {{$filter_setting->barangay}}
                        @else
                        Name
                        @endif
                        </span>
                    </a>
                    <a href="{{ route('secretary.home') }}" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        @if(!empty($filter_setting->logo))
                        <img class="mx-auto d-block d-none d-sm-inline" src="{{asset('images/barangay_logo/'.$filter_setting->logo.'')}}" alt="Your Barangay Logo here" style="width: 40%">
                        @else
                        <img class="mx-auto d-block d-none d-sm-inline" src="{{asset('images/baggao_logo.png')}}" alt="Your Barangay Logo here" style="width: 40%;">
                        @endif
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="{{ route('secretary.home') }}" type="button" class="nav-link align-middle px-2 fs-5 text-white home-loading">
                                <i class="bi-house-door-fill sidebar-home"></i> <span class="ms-1 d-none d-sm-inline sidebar-home">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-2 fs-5 align-middle text-white dropdown-toggle">
                                <i class="bi-geo-alt sidebar-brgy"></i>  <span class="ms-1 d-none d-sm-inline sidebar-brgy">Barangay</span> </a>
                            <ul class="collapse hide nav flex-column" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100 m-0">
                                    <a href="{{ route('resident') }}" class="nav-link p-1 text-white" style="font-size: 15px; margin-left: 30px">

                                        <span class="sidebar-residents" style="font-size: 15px"> Residents</span>
                                    </a>
                                    <a href="{{route('barangay.resident_account')}}" class="nav-link p-1 text-white">
             
                                        <span class="sidebar-accounts" style="font-size: 15px; margin-left: 30px"> Resident Accounts</span>
                                    </a>
                                    <a href="{{route('barangay.officials')}}" class="nav-link p-1 text-white">
                          
                                        <span class="sidebar-officials" style="font-size: 15px; margin-left: 30px"> Barangay Officials</span>
                                    </a>
                                    <a href="{{route('barangay.zone')}}" class="nav-link p-1  text-white">
                                    
                                        <span class="sidebar-zone" style="font-size: 15px; margin-left: 30px"> Zone</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-2 fs-5 align-middle text-white dropdown-toggle">
                                <i class="bi-journal-text sidebar-issuance"></i>  <span class="ms-1 d-none d-sm-inline sidebar-issuance">Issuance</span> </a>
                            <ul class="collapse hide nav flex-column" id="submenu2" data-bs-parent="#menu2">
                                <li class="w-100 m-0">
                                    <a href="{{ route('barangay.blotter') }}" class="nav-link p-1 text-white" style="font-size: 15px; margin-left: 30px">

                                        <span class="sidebar-blotters" style="font-size: 15px"> Blotters</span>
                                    </a>
                                    <a href="{{route('get-certificate.layout')}}" class="nav-link p-1 text-white">
             
                                        <span class="sidebar-certificates" style="font-size: 15px; margin-left: 30px"> Certificates</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-2 fs-5 align-middle text-white dropdown-toggle">
                                <i class="bi-newspaper sidebar-reports"></i>  <span class="ms-1 d-none d-sm-inline sidebar-reports">Reports</span> </a>
                            <ul class="collapse hide nav flex-column" id="submenu3" data-bs-parent="#menu3">
                                <li class="w-100 m-0">
                                    {{-- <a href="{{ route('resident.per-zone') }}" class="nav-link p-1 text-white" style="font-size: 15px; margin-left: 30px">
                                        <span class="sidebar-filter-zone" style="font-size: 15px">Residents <span style="font-size: 12px">(per zone)</span></span>
                                    </a> --}}
                                    <a href="{{route('household')}}" class="nav-link p-1 text-white">
                                        <span class="sidebar-households" style="font-size: 15px; margin-left: 30px"> List of Household</span>
                                    </a>
                                    <a href="{{route('senior')}}" class="nav-link p-1 text-white">
                                        <span class="sidebar-senior" style="font-size: 15px; margin-left: 30px"> Senior Citizens</span>
                                    </a>
                                    <a href="{{ route('certificate.reports') }}" class="nav-link p-1 text-white">
                                        <span class="sidebar-certificate" style="font-size: 15px; margin-left: 30px"> Certificates</span>
                                    </a>
                                    <a href="{{ route('report.file') }}" class="nav-link p-1 text-white">
                                        <span class="sidebar-files" style="font-size: 15px; margin-left: 30px"> Files</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('barangay.announcement')}}" class="nav-link align-middle px-2 fs-5 text-white">
                                <i class="bi-megaphone-fill sidebar-announcement"></i> <span class="ms-1 d-none d-sm-inline sidebar-announcement">Announcements</span>
                            </a>
                        </li>
                        <li>
                            <a href="#submenu4" data-bs-toggle="collapse" class="nav-link px-2 fs-5 align-middle text-white dropdown-toggle">
                                <i class="bi-wrench sidebar-settings"></i>  <span class="ms-1 d-none d-sm-inline sidebar-settings">Settings</span> </a>
                            <ul class="collapse hide nav flex-column" id="submenu4" data-bs-parent="#menu4">
                                <li class="w-100 m-0">
                                    <a href="/barangay/settings" class="nav-link p-1 text-white">
                                        <span class="sidebar-brgy-setting" style="font-size: 15px; margin-left: 30px"> Barangay</span>
                                    </a>
                                    <a href="/barangay/certificate-types" class="nav-link p-1 text-white">
                                        <span class="sidebar-types" style="font-size: 15px; margin-left: 30px"> Certificate Types</span>
                                    </a>
                                    <a href="/barangay/certificate-layouts" class="nav-link p-1 text-white">
                                        <span class="sidebar-layouts" style="font-size: 15px; margin-left: 30px"> Certificate Layouts</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/baggao_logo.png') }}" alt="hugenerd" width="28" height="28" class="rounded-circle">
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
                </div>
            </div>
            <div class="col d-flex flex-column justify-content-start h-sm-100">
                <main class="row overflow-auto">
                    <div class="col pt-4 h-100">
                        @yield('content')
                    </div>
                </main>
                <footer class="row bg-light mt-auto">
                    <div class="text-center">
                        <span class="text-muted">
                            &copy; {{ date('Y') }} SJCBI Batch 2022.
                            All Rights Reserved
                            </span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>
<script>
    var width = $(window).width();

    if(width <= 768){
        $('#brgy_name').attr('hidden', true);
        $('#submenu1').addClass('hide').removeClass('show');
        $('#submenu2').addClass('hide').removeClass('show');
        $('#submenu3').addClass('hide').removeClass('show');
        $('#submenu4').addClass('hide').removeClass('show');
    }
</script>
</body>
</html>
