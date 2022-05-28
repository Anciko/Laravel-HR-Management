<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.css" rel="stylesheet" />

    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href=" https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">

    <!-- Daterange picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!--- Box icon  -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">
    <div id="app">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel" style="max-width: 260px;">
            <div class="offcanvas-header shadow-sm">
                <h6 class="offcanvas-title" id="offcanvasExampleLabel">Ninja HR</h6>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row shadow-sm">
                    <div class="col-6">
                        <img src="{{ asset('image/ninja.png') }}" alt="HR" class="img-fluid" width="100">
                    </div>
                    <div class="col-6 mt-4">
                        <p class="mb-0 ">John Smith</p>
                        <small class="text-muted ">Administrator</small>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="">Menu</p>
                    <div class="list-group list-group-light">
                        <a href="#" class="list-group-item list-group-item-action px-3 border-0 " aria-current="true">
                            <i class='bx bx-home bx-sm me-4 align-middle'></i>Home
                        </a>
                        <a href="{{ route('employee.index') }}"
                            class="list-group-item list-group-item-action px-3 border-0">
                            <i class='bx bxs-group bx-sm me-4 align-middle'></i>Employees
                        </a>
                        <a href="{{ route('department.index') }}"
                            class="list-group-item list-group-item-action px-3 border-0">
                            <i class='bx bx-sitemap bx-sm me-4 align-middle'></i>Departments
                        </a>
                        <a href="{{ route('role.index') }}"
                            class="list-group-item list-group-item-action px-3 border-0">
                            <i class='fa-solid fa-user-gear me-4 align-middle'></i>Role
                        </a>
                        <a href="{{ route('permission.index') }}"
                            class="list-group-item list-group-item-action px-3 border-0">
                            <i class='bx bx-check-shield  bx-sm me-4 align-middle'></i>Permission
                        </a>

                        <a href="#" class="list-group-item list-group-item-action px-3 border-0">Morbi leo risus</a>
                        <a href="#" class="list-group-item list-group-item-action px-3 border-0">Porta ac consectetur
                            ac</a>
                        <a class="list-group-item list-group-item-action px-3 border-0 disabled">Vestibulum at eros</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="header-menu shadow-sm p-2 bg-white d-flex">
            @if (request()->is('/'))
                <div class="col-2 text-center pt-1" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                    role="button" aria-controls="offcanvasExample">
                    <i class='bx bx-menu-alt-left bx-sm text-secondary'></i>
                </div>
            @else
                <div class="col-2 text-center pt-1" role="button">
                    <a href="" class="text-secondary previousLink">
                        <i class='bx  bx-arrow-back bx-sm '></i>
                    </a>
                </div>
            @endif
            <div class="col-8">
                <h5 class="text-center  mb-0 align-self-center"> @yield('title') </h5>
            </div>
        </div>
        <main class="pt-4 my-4">
            <div class="">
                <div class="col-8 mx-auto">
                    @yield('content')
                    <div style="width: 100%; height: 50px;"></div>
                </div>
            </div>
        </main>
        <footer
            class=" bottom-menu bg-white py-2 shadow-lg position-fixed bottom-0  w-100 d-flex justify-content-evenly"
            style="z-index: 10">
            <a href="" class=" text-center text-dark d-flex flex-column">
                <i class='bx bxs-home bx-tada-hover fs-5'></i>
                <span class="m-0 fs">Home</span>
            </a>
            <a href="" class="text-center text-dark d-flex flex-column">
                <i class='bx bxs-home bx-tada-hover fs-5'></i>
                <p class="m-0 fs">Home</p>
            </a>
            <a href="" class="text-center text-dark d-flex flex-column">
                <i class='bx bxs-home bx-tada-hover fs-5'></i>
                <p class="m-0 fs">Home</p>
            </a>
            <a href="{{ route('profile') }}" class="text-center text-dark d-flex flex-column">
                <i class='bx bxs-user bx-tada-hover fs-5'></i>
                <p class="m-0 fs">My Profile</p>
            </a>
        </footer>
    </div>


    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Datatable -->
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap.min.js"></script>
    <!-- Datatable mark.js -->
    <script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"></script>
    <!-- Moment -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- Daterange picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <!-- Sweet Alert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            if (token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token.content
                    }
                });
            } else {
                console.error('CSRF TOKEN not found!');
            }

            $(document).on('click', '.previousLink', function(e) {
                e.preventDefault();
                window.history.back();
            })
        })
    </script>
    @stack('scripts')
</body>

</html>
