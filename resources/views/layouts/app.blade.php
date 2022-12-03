<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Centralized Barangay Information System</title>
    {{-- icon --}}
    <link rel="icon" href="{{ url('images/baggao_logo.png') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



    <!-- Scripts -->
    {{-- jquery --}}
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script> --}}
    


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>
        .navs, #toggler {
            display: none;
        }

        @media only screen and (max-width: 768px){
        .navs, #toggler {
            display: block;
            }
        }
        .toast {
            opacity: 1 !important;
        }

        .active a{
            color: rgb(0, 0, 0);
       }
    </style>

</head>
<body>

    <div id="app">
        @auth
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/resident/home') }}">
                    @if(Auth::user()->is_role == 2)
                        <strong>{{$barangay_name}} Online Portal</strong>
                    @endif
                </a>

                <div id="toggler">
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                </div>
                  
                  <div class="offcanvas offcanvas-end text-bg-dark" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
                    <div class="offcanvas-header">
                      <h4 class="offcanvas-title fs-bold" id="staticBackdropLabel"><a class=" nav-link" href="{{ route('resident.home') }}">{{ auth()->user()->name }}</a></h4>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                      <div class="navs">
                        <nav class="nav flex-column align-items-center">
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white fs-5 request"  href="#">Request</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white fs-5" href="{{ route('resident.profile') }}">Profile</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link text-white fs-5" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                          </nav>
                      </div>
                    </div>
                  </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a  class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item {{ request()->routeIs('resident.home') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('resident.home') }}">
                                    <h5>{{ auth()->user()->name }}</h5>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link request" href="#" role="button">
                                    Request
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('resident.profile') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('resident.profile') }}">
                                    Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endauth


        <main class="py-4">
            @yield('content')
        </main>
    </div>

<script>
    //ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        // TOASTR OPTIONS
        toastr.options = {
                "debug": false,
                "newestOnTop": true,
                "closeButton": true,
                "positionClass": "toast-top-full-width",
                "preventDuplicates": true,
                "showDuration": "10000",
                "hideDuration": "10000",
                "timeOut": "20000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
        }

        //add function
        $('#savedata').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#certificateForm').serialize(),
            url: "{{ route('resident.request')}}",
            type: "POST",
            dataType: "json",
                success: function (data) {
                    $('#certificateForm').trigger("reset");
                    $('#certificateModal').modal('hide');
                    $('.btn-close').click();
                    toastr.success('Request submitted successfully. You will receive an email when your request is already available.','Success');
                },
                error: function (data) {
                    toastr.error(data['responseJSON']['message'],'Error has occured');

                }
            });
        });



</script>
</body>
</html>
