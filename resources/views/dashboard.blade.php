<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('templetes/kaiadmin-lite/assets/img/kaiadmin/favicon.ico') }}"
        type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('templetes/kaiadmin-lite/assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->

    <link rel="stylesheet" href="{{ asset('templetes/kaiadmin-lite/assets/css/demo.css') }}" />
</head>

<body>
    {{-- @php
        dd(session()->all());
    @endphp --}}
    {{-- ✅ Success --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK' // tulisan tombol
            });
        </script>
    @endif


    {{-- ❌ Error dari session (catch di controller) --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        </script>
    @endif

    {{-- ⚠️ Error dari Laravel validation --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`, // tampilkan semua error dalam 1 popup
            });
        </script>
    @endif

    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2" data-background-color="dark">
            <div class="sidebar-logo">
                <!-- Logo Header -->
                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="{{ asset('logo/logo mcsn.png') }}"
                            alt="navbar brand" class="navbar-brand" height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
                <!-- End Logo Header -->
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="dashboard">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="../demo1/index.html">
                                            <span class="sub-item">Dashboard 1</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Manu</h4>
                        </li>
                        @foreach (config('menu.' . auth()->user()->getRoleNames()->first()) as $menu)
                            {{-- <li><a href="{{ route($menu['route']) }}">{{ $menu['name'] }}</a></li> --}}
                            <li class="nav-item">
                                <a href="{{ route($menu['route']) }}">
                                    <i class="fas fa-{{ $menu['icon'] }}"></i>
                                    <p>{{ $menu['name'] }}</p>
                                    {{-- <span class="badge badge-success">4</span> --}}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <a href="index.html" class="logo">
                            <img src="{{ asset('templetes/kaiadmin-lite/assets/img/kaiadmin/logo_light.svg') }}"
                                alt="navbar brand" class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <nav
                            class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control" />
                            </div>
                        </nav>

                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                                    role="button" aria-expanded="false" aria-haspopup="true">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control" />
                                        </div>
                                    </form>
                                </ul>
                            </li>
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-envelope"></i>
                                </a>
                                <ul class="dropdown-menu messages-notif-box animated fadeIn"
                                    aria-labelledby="messageDropdown">
                                    <li>
                                        <div class="dropdown-title d-flex justify-content-between align-items-center">
                                            Messages
                                            <a href="#" class="small">Mark all as read</a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="message-notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="{{ asset('templetes/kaiadmin-lite/assets/img/jm_denis.jpg') }}"
                                                            alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="subject">Jimmy Denis</span>
                                                        <span class="block"> How are you ? </span>
                                                        <span class="time">5 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="{{ asset('templetes/kaiadmin-lite/assets/img/chadengle.jpg') }} "
                                                            alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="subject">Chad</span>
                                                        <span class="block"> Ok, Thanks ! </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="{{ asset('templetes/kaiadmin-lite/assets/img/mlane.jpg') }}"
                                                            alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="subject">Jhon Doe</span>
                                                        <span class="block">
                                                            Ready for the meeting today...
                                                        </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="{{ asset('templetes/kaiadmin-lite/assets/img/talha.jpg') }}"
                                                            alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="subject">Talha</span>
                                                        <span class="block"> Hi, Apa Kabar ? </span>
                                                        <span class="time">17 minutes ago</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="javascript:void(0);">See all messages<i
                                                class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell"></i>
                                    <span class="notification">4</span>
                                </a>
                                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                                    <li>
                                        <div class="dropdown-title">
                                            You have 4 new notification
                                        </div>
                                    </li>
                                    <li>
                                        <div class="notif-scroll scrollbar-outer">
                                            <div class="notif-center">
                                                <a href="#">
                                                    <div class="notif-icon notif-primary">
                                                        <i class="fa fa-user-plus"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block"> New user registered </span>
                                                        <span class="time">5 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-icon notif-success">
                                                        <i class="fa fa-comment"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            Rahmad commented on Admin
                                                        </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-img">
                                                        <img src="{{ asset('templetes/kaiadmin-lite/assets/img/profile2.jpg') }}"
                                                            alt="Img Profile" />
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block">
                                                            Reza send messages to you
                                                        </span>
                                                        <span class="time">12 minutes ago</span>
                                                    </div>
                                                </a>
                                                <a href="#">
                                                    <div class="notif-icon notif-danger">
                                                        <i class="fa fa-heart"></i>
                                                    </div>
                                                    <div class="notif-content">
                                                        <span class="block"> Farrah liked Admin </span>
                                                        <span class="time">17 minutes ago</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="see-all" href="javascript:void(0);">See all notifications<i
                                                class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item topbar-icon dropdown hidden-caret">
                                <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fas fa-layer-group"></i>
                                </a>
                                <div class="dropdown-menu quick-actions animated fadeIn">
                                    <div class="quick-actions-header">
                                        <span class="title mb-1">Quick Actions</span>
                                        <span class="subtitle op-7">Shortcuts</span>
                                    </div>
                                    <div class="quick-actions-scroll scrollbar-outer">
                                        <div class="quick-actions-items">
                                            <div class="row m-0">
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-danger rounded-circle">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </div>
                                                        <span class="text">Calendar</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-warning rounded-circle">
                                                            <i class="fas fa-map"></i>
                                                        </div>
                                                        <span class="text">Maps</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-info rounded-circle">
                                                            <i class="fas fa-file-excel"></i>
                                                        </div>
                                                        <span class="text">Reports</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-success rounded-circle">
                                                            <i class="fas fa-envelope"></i>
                                                        </div>
                                                        <span class="text">Emails</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-primary rounded-circle">
                                                            <i class="fas fa-file-invoice-dollar"></i>
                                                        </div>
                                                        <span class="text">Invoice</span>
                                                    </div>
                                                </a>
                                                <a class="col-6 col-md-4 p-0" href="#">
                                                    <div class="quick-actions-item">
                                                        <div class="avatar-item bg-secondary rounded-circle">
                                                            <i class="fas fa-credit-card"></i>
                                                        </div>
                                                        <span class="text">Payments</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item topbar-user dropdown hidden-caret">
                                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                    aria-expanded="false">
                                    <div class="avatar-sm">
                                        <img src="{{ asset('templetes/kaiadmin-lite/assets/img/profile.jpg') }}"
                                            alt="..." class="avatar-img rounded-circle" />
                                    </div>
                                    <span class="profile-username">
                                        <span class="op-7">Hi,</span>
                                        <span class="fw-bold">{{ session('user.name') }}</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user animated fadeIn">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg">
                                                    <img src="{{ asset('templetes/kaiadmin-lite/assets/img/profile.jpg') }}"
                                                        alt="image profile" class="avatar-img rounded" />
                                                </div>
                                                <div class="u-text">
                                                    <h4>{{ session('user.name') }}</h4>
                                                    <p class="text-muted">{{ session('user.email') }}</p>
                                                    {{-- <a href="profile.html"
                                                        class="btn btn-xs btn-secondary btn-sm">View Profile</a> --}}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            @if (session('user.role') == 'patient')
                                                <a class="dropdown-item"
                                                    href="{{ route('patient.show', ['patient' => session('user.id')]) }}">My
                                                    Profile</a>
                                                <div class="dropdown-divider"></div>
                                            @endif
                                            <a class="dropdown-item" href="#">Account Setting</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>

                                        </li>
                                    </div>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        @php
                            $segments = Request::segments();
                        @endphp

                        <ul class="breadcrumbs mb-3">
                            {{-- Home --}}
                            <li class="nav-home">
                                <a href="{{ url('/') }}">
                                    <i class="icon-home"></i>
                                </a>
                            </li>

                            @foreach ($segments as $index => $segment)
                                {{-- separator --}}
                                <li class="separator">
                                    <i class="icon-arrow-right"></i>
                                </li>

                                {{-- breadcrumb item --}}
                                <li class="nav-item {{ $loop->last ? 'active' : '' }}">
                                    @php
                                        $url = url(implode('/', array_slice($segments, 0, $index + 1)));

                                        // Replace numeric segments with "Show"
                                        $label = is_numeric($segment) ? 'Show' : ucfirst($segment);
                                    @endphp

                                    @if (!$loop->last)
                                        <a href="{{ $url }}">{{ $label }}</a>
                                    @else
                                        <span>{{ $label }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                    </div>

                    @if (Route::current()->getName() == 'dashboard')
                        @if (session('user.roles') == 'patient')
                            <div>
                                <img class="img-fluid" src="{{ asset('banner/banner home patient.jpeg') }}" alt="">
                            </div>
                            <!-- TimeLine -->
                            <h3 class="fw-bold mb-3">Timeline</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="timeline">
                                        {{-- <li>
                                            <div class="timeline-badge"><i class="far fa-paper-plane"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">Mussum ipsum cacilds</h4>
                                                    <p>
                                                        <small class="text-muted"><i class="far fa-paper-plane"></i>
                                                            11 hours ago via Twitter</small>
                                                    </p>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>
                                                        Far far away, behind the word mountains, far from the countries
                                                        Vokalia
                                                        and Consonantia, there live the blind texts.
                                                    </p>
                                                </div>
                                            </div>
                                        </li> --}}
                                        <li class="timeline-inverted">
                                            <div class="timeline-badge success"><i class="fas fa-user"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">Pasien</h4>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>
                                                        Pasien mengisi login dan mengisi keluhan pada aplikasi/website.
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-badge warning"><i class="fas fa-cog"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">Admin</h4>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>
                                                        Admin menjadwalkan waktu konsultasi dan menentukan dokter yang sesuai dengan keluhan pasien.
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-badge warning"><i class="fas fa-cog"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">Admin</h4>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>
                                                        Jadwal dikirimkan ke pasien melalui WhatsApp.
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-inverted">
                                            <div class="timeline-badge success"><i class="fas fa-user"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">Pasien</h4>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>
                                                        Pasien hadir di klinik sakit sesuai jadwal yang telah ditentukan. lalu pasien melakukan registrasi kedatangan.
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-badge info"><i class="fas fa-plus-square"></i></div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">Dokter</h4>
                                                </div>
                                                <div class="timeline-body">
                                                    <p>
                                                        Dokter Melakukan Analisa terhadap Pasien.
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <a href="{{ route('appoinment.create') }}">
                                        <div class="card card-stats card-primary card-round">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="icon-big text-center">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-7 col-stats">
                                                        <div class="numbers">
                                                            <h3 class="card-title">Book Appointment</h3>
                                                            {{-- <h4 class="card-title">1,294</h4> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                {{-- <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-info card-round">
                                        <div class="card-body">
                                            <div class="row">
                                            <div class="col-5">
                                                <div class="icon-big text-center">
                                                <i class="fas fa-history"></i>
                                                </div>
                                            </div>
                                            <div class="col-7 col-stats">
                                                <div class="numbers">
                                                <h3 class="card-title">Medial History</h3>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        @endif
                    @endif

                    @yield('content')
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between">
                    <nav class="pull-left">
                        {{-- <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="http://www.themekita.com">
                                    ThemeKita
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Help </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"> Licenses </a>
                            </li>
                        </ul> --}}
                    </nav>
                    <div class="copyright">
                        E-Klinik
                        {{-- 2024, made with <i class="fa fa-heart heart text-danger"></i> by
                        <a href="http://www.themekita.com">ThemeKita</a> --}}
                    </div>
                    <div>
                        {{-- Distributed by
                        <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>. --}}
                    </div>
                </div>
            </footer>
        </div>

        <!-- Custom template | don't include it in your project! -->
        {{-- <div class="custom-template">
            <div class="title">Settings</div>
            <div class="custom-content">
                <div class="switcher">
                    <div class="switch-block">
                        <h4>Logo Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="selected changeLogoHeaderColor" data-color="dark"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
                            <button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Navbar Header</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeTopBarColor" data-color="dark"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue"></button>
                            <button type="button" class="changeTopBarColor" data-color="green"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange"></button>
                            <button type="button" class="changeTopBarColor" data-color="red"></button>
                            <button type="button" class="selected changeTopBarColor" data-color="white"></button>
                            <br />
                            <button type="button" class="changeTopBarColor" data-color="dark2"></button>
                            <button type="button" class="changeTopBarColor" data-color="blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="purple2"></button>
                            <button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
                            <button type="button" class="changeTopBarColor" data-color="green2"></button>
                            <button type="button" class="changeTopBarColor" data-color="orange2"></button>
                            <button type="button" class="changeTopBarColor" data-color="red2"></button>
                        </div>
                    </div>
                    <div class="switch-block">
                        <h4>Sidebar</h4>
                        <div class="btnSwitch">
                            <button type="button" class="changeSideBarColor" data-color="white"></button>
                            <button type="button" class="selected changeSideBarColor" data-color="dark"></button>
                            <button type="button" class="changeSideBarColor" data-color="dark2"></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-toggle">
                <i class="icon-settings"></i>
            </div>
        </div> --}}
        <!-- End Custom template -->
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/core/bootstrap.min.js') }}"></script>

    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}">
    </script>

    {{-- <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}">
    </script>

    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}">
    </script>

    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/jsvectormap/world.js') }}"></script> --}}

    <!-- Datatables -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        })
    </script>

    <!-- Sweet Alert -->
    {{-- <script src="{{ asset('templetes/kaiadmin-lite/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script> --}}


    <!-- Kaiadmin JS -->
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/kaiadmin.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        $(function() {
            $('#summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['view', ['codeview']]
                ]
            });
        });
        $(function() {
            $('#summernote1').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['table']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    {{-- <script src="{{ asset('templetes/kaiadmin-lite/assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('templetes/kaiadmin-lite/assets/js/demo.js') }}"></script> --}}
    {{-- <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script> --}}
</body>

</html>
