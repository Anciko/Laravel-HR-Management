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
    <!--- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="{{ asset('css/select2-material.css') }}"> -->

    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('styles')
</head>

<body class="bg-color">
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
                        <a href="#" class="list-group-item list-group-item-action px-3 border-0 "
                            aria-current="true">
                            <i class='bx bx-home bx-sm me-4 align-middle'></i>Home
                        </a>

                        @can('view_employee')
                            <a href="{{ route('employee.index') }}"
                                class="list-group-item list-group-item-action px-3 border-0">
                                <i class='bx bxs-group bx-sm me-4 align-middle'></i>Employees
                            </a>
                        @endcan

                        @can('view_department')
                            <a href="{{ route('department.index') }}"
                                class="list-group-item list-group-item-action px-3 border-0">
                                <i class='bx bx-sitemap bx-sm me-4 align-middle'></i>Departments
                            </a>
                        @endcan

                        @can('view_role')
                            <a href="{{ route('role.index') }}"
                                class="list-group-item list-group-item-action px-3 border-0">
                                <i class='fa-solid fa-user-gear me-4 align-middle'></i>Role
                            </a>
                        @endcan

                        @can('view_permission')
                            <a href="{{ route('permission.index') }}"
                                class="list-group-item list-group-item-action px-3 border-0">
                                <i class='fa-solid fa-user-shield me-4 align-middle'></i>Permission
                            </a>
                        @endcan

                        @can('view_company_setting')
                            <a href="{{ route('company-setting.show', 1) }}"
                                class="list-group-item list-group-item-action px-3 border-0">
                                <i class="fa-solid fa-building me-4 align-middle"></i>Company Setting
                            </a>
                        @endcan

                        @can('view_attendance')
                            <a href="{{ route('attendance.index') }}"
                                class="list-group-item list-group-item-action px-3 border-0">
                                <i class="fa-solid fa-calendar-check me-3 align-middle"></i>Attendance <span class="ms-4">(Employee)</span>
                            </a>
                        @endcan

                        @can('view_attendance_overview')
                            <a href="{{ route('attendance.overview') }}"
                                class="list-group-item list-group-item-action px-3 border-0">
                                <i class="fa-solid fa-calendar-check me-3 align-middle"></i>Attendance <span class="ms-4">(Overview)</span>
                            </a>
                        @endcan

                         @can('view_salary')
                            <a href="{{ route('salary.index') }}"
                                class="list-group-item list-group-item-action px-3 ">
                                <i class="fa-solid fa-hand-holding-dollar me-3 align-middle"></i><span>Salary</span>
                            </a>
                        @endcan

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
            <div class="col-10 mx-auto">
                @yield('content')
                <div style="width: 100%; height: 50px;"></div>
            </div>
        </main>
        <footer
            class=" bottom-menu bg-white py-2 shadow-lg position-fixed bottom-0  w-100 d-flex justify-content-evenly"
            style="z-index: 10">
            <a href="{{ route('home') }}" class=" text-center text-dark d-flex flex-column">
                <i class='bx bxs-home bx-tada-hover fs-5'></i>
                <span class="m-0 fs">Home</span>
            </a>
            <a href="{{ route('attendance-scan') }}" class="text-center text-dark d-flex flex-column">
                <i class='bx  bxs-calendar-alt bx-tada-hover fs-5'></i>
                <p class="m-0 fs">Attendance</p>
            </a>
            <a href="" class="text-center text-dark d-flex flex-column">
                <i class='bx bx-briefcase-alt-2 bx-tada-hover fs-5'></i>
                <p class="m-0 fs">Project</p>
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
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/qr-scanner.umd.min.js') }}"></script>

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

            $(".ninja-select").select2();
        })
    </script>
    @stack('scripts')
</body>

</html>
