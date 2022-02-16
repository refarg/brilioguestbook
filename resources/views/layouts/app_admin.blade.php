<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @yield('meta')
  <title>{{ isset($title) ? $title : config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('a-tmp/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('a-tmp/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('a-tmp/css/adminlte.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('a-tmp/plugins/toastr/toastr.min.css') }}">
  
  <!-- Additional Style -->
  @stack('css')
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item dropdown user user-menu">
  <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
    <img src="{{asset('a-tmp/img/user2-160x160.jpg')}}" class="user-image img-circle elevation-2" alt="User Image">
    <span class="d-none d-md-block float-right">{{ Auth::user()->name }}</span>
  </a>
  <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <!-- User image -->
    <li class="user-header bg-dark">
      <img src="{{asset('a-tmp/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">

      <p>
        {{ Auth::user()->first_name . " " . Auth::user()->last_name }}
        <small>Member since {{ Auth::user()->created_at->format('M Y') }}</small>
      </p>
    </li>
    <!-- Menu Footer-->
    <li class="user-footer rounded-bottom">
      <div class="float-left">
        <a href="#" class="btn btn-default btn-flat">Profile</a>
      </div>
      <div class="float-right">
        <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </div>
    </li>
  </ul>
</li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <x-application-logo alt="Brilio Logo" class="brand-image" style="opacity: 1; width: 30px;" />
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @include('layouts.navbar_admin')
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <div class="sidebar-custom">
    <ul class="nav nav-pills nav-sidebar flex-column">
      <li class="nav-item">
        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
        <i class="fas fa-sign-out-alt"></i>
          <p>
            Logout
          </p>
        </a>
      </li>
    </ul>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $page ?? "" }}</h1>
          </div><!-- /.col -->
          @if(isset($title))
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active"><a href="{{ $breadcrumb ?? '' }}">{{ $title ?? "" }}</a></li>
              <li class="breadcrumb-item active">{{ $page ?? "" }}</li>
            </ol>
          </div><!-- /.col -->
          @endif
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('main')
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright <a href="https://adminlte.io">{{ config('app.name') }}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('a-tmp/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('a-tmp/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('a-tmp/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('a-tmp/js/adminlte.js') }}"></script>
<script src="{{ asset('a-tmp/plugins/toastr/toastr.min.js') }}"></script>
<!-- Additional Scripts -->
@stack('js')
@if(session()->exists('status_message'))
<script type="text/javascript">
  toastr.success("{{ session()->get('status_message') }}");
</script>
@endif

</body>
</html>
