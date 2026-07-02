<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Dashboard') - Darussalam Laundry</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('template/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">

    <style>
        /* ===== COMPATIBILITY LAYER FOR EXISTING VIEWS ===== */
        .content-card {
            background: #191c24;
            border: none;
            border-radius: 5px;
            padding: 24px;
            margin-bottom: 24px;
            color: #6c7293;
        }

        .card-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #000000;
        }

        .card-header-custom h5 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
        }

        .table-dark-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table-dark-custom thead th {
            background-color: #000000;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #191c24;
            padding: 12px 15px;
            text-align: left;
        }

        .table-dark-custom tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #191c24;
            color: #6c7293;
            font-size: 0.9rem;
        }

        .table-dark-custom tbody tr:hover {
            background-color: #000000;
            color: #ffffff;
        }

        /* ===== BUTTONS ===== */
        .btn-accent {
            background-color: #eb1616;
            color: #ffffff !important;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-accent:hover {
            background-color: #c90e0e;
            color: #ffffff;
            text-decoration: none;
        }

        .btn-sm-custom {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #000000 !important;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #ffffff !important;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-success-custom {
            background-color: #198754;
            color: #ffffff !important;
        }

        .btn-success-custom:hover {
            background-color: #157347;
        }

        /* ===== BADGES ===== */
        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-baru {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .badge-selesai {
            background: rgba(25, 135, 84, 0.2);
            color: #198754;
        }

        /* ===== FORM INPUTS ===== */
        .form-control-dark {
            background: #000000;
            border: 1px solid #2a2e38;
            border-radius: 4px;
            padding: 10px 16px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s;
            width: 100%;
        }

        .form-control-dark:focus {
            outline: none;
            border-color: #eb1616;
            background: #000000;
            color: #ffffff;
        }

        .form-control-dark::placeholder {
            color: #495057;
        }

        .form-label-dark {
            color: #ffffff;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        /* ===== ALERT MESSAGES ===== */
        .alert-custom {
            padding: 14px 20px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success-custom {
            background-color: rgba(25, 135, 84, 0.2);
            border: 1px solid #198754;
            color: #198754;
        }

        .alert-danger-custom {
            background-color: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #dc3545;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: #191c24;
            border-radius: 5px;
            padding: 24px;
            display: grid;
            grid-template-areas:
                "icon value"
                "icon label";
            grid-column-gap: 20px;
            align-items: center;
            justify-content: start;
        }

        .stat-card .stat-icon {
            grid-area: icon;
            font-size: 2.5rem !important;
            width: 60px;
            height: 60px;
            background: transparent !important;
            color: #eb1616 !important;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card .stat-value {
            grid-area: value;
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
        }

        .stat-card .stat-label {
            grid-area: label;
            font-size: 13px;
            color: #6c7293;
        }

        /* Adjust global wrapper */
        .content {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== GLOBAL PRINT STYLES ===== */
        @media print {
            .print-header-logo {
                display: flex !important;
            }

            .sidebar,
            .navbar,
            .no-print,
            .back-to-top,
            #spinner,
            footer,
            .btn-close {
                display: none !important;
            }

            body,
            .container-fluid,
            .content,
            .main-panel,
            .content-wrapper {
                background: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
                min-height: auto !important;
                box-shadow: none !important;
            }

            .content-card,
            .card,
            .bg-secondary {
                background: #ffffff !important;
                color: #000000 !important;
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
                margin-bottom: 15px !important;
                padding: 15px !important;
                border-radius: 4px !important;
            }

            h1, h2, h3, h4, h5, h6, p, span, td, th, strong, div, label {
                color: #000000 !important;
            }

            .text-muted, .text-sm-muted {
                color: #555555 !important;
            }

            .table-dark-custom,
            .table {
                color: #000000 !important;
                border-collapse: collapse !important;
                width: 100% !important;
            }

            .table-dark-custom thead th,
            .table thead th {
                background-color: #f8f9fa !important;
                color: #000000 !important;
                border: 1px solid #dee2e6 !important;
                padding: 8px !important;
                font-weight: bold !important;
            }

            .table-dark-custom tbody td,
            .table tbody td {
                background-color: transparent !important;
                color: #000000 !important;
                border: 1px solid #dee2e6 !important;
                padding: 8px !important;
            }

            .badge,
            .badge-status {
                background: transparent !important;
                color: #000000 !important;
                border: 1px solid #000000 !important;
                padding: 2px 6px !important;
            }

            /* Stack grid columns for portrait print layout */
            .col-12, .col-sm-6, .col-md-5, .col-md-7, .col-md-6 {
                width: 100% !important;
                flex: 0 0 100% !important;
                max-width: 100% !important;
                margin-bottom: 15px !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        {{-- Include Sidebar --}}
        @include('layouts.sidebar')

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0" style="height: 64px;">
                <a href="{{ route('dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
                    <img src="{{ asset('darussalam_logo.png') }}" alt="Logo" style="height: 35px; border-radius: 4px;">
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white bg-dark border border-primary me-lg-2" style="width: 30px; height: 30px; font-weight: bold; font-size: 12px; display: inline-flex !important;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-lg-inline-flex text-white">{{ auth()->user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <span class="dropdown-item disabled text-muted">
                                <i class="fa fa-user-shield me-2 text-info"></i> {{ auth()->user()->level->level_name }}
                            </span>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Main Content Area -->
            <div class="container-fluid pt-4 px-4">
                @yield('content')
            </div>

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4 mt-auto mb-4 no-print">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start text-muted">
                            &copy; <a href="{{ route('dashboard') }}" class="text-white fw-bold">Darussalam Laundry</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('template/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('template/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('template/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('template/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('template/js/main.js') }}"></script>

    <!-- SweetAlert2 & Flash Messages -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Flash message success
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#eb1616',
                background: '#191c24',
                color: '#ffffff',
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        // Flash message error
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#eb1616',
                background: '#191c24',
                color: '#ffffff',
            });
        @endif

        // Konfirmasi hapus dengan SweetAlert
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#191c24',
                color: '#ffffff',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
