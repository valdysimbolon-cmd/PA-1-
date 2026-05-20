<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Teknik Bioproses</title>

    <!-- Font & Style Standar -->
    <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom CSS untuk Warna Espresso & Pistachio -->
    <style>
        .bg-gradient-success {
            background-color: #200F07 !important;
            background-image: linear-gradient(180deg, #200F07 10%, #351a0d 100%) !important;
        }
        .text-pistachio { color: #C5E384 !important; }
        .text-espresso { color: #200F07 !important; }
        .sidebar-dark .nav-item.active .nav-link,
        .sidebar-dark .nav-item.active .nav-link i { color: #C5E384 !important; font-weight: bold; }
        .sidebar-dark .nav-item .nav-link:hover,
        .sidebar-dark .nav-item .nav-link:hover i { color: #C5E384 !important; }
        footer.sticky-footer { padding: 2rem 0; flex-shrink: 0; }
    </style>
    
    @stack('styles')
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- 1. Include Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- 2. Include Topbar -->
                @include('layouts.partials.topbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    
                    <!-- Alert Success/Error Global -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- YIELD CONTENT UTAMA -->
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- 3. Include Footer -->
            @include('layouts.partials.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- 4. Include Scripts -->
    @include('layouts.partials.scripts')

    @stack('scripts')
</body>
</html>