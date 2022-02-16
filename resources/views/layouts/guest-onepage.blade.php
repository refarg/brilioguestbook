<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Brilio Guest Book</title>

    <!-- Font Icon -->

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('gb-tmp/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('a-tmp/plugins/toastr/toastr.min.css') }}">

    <!-- Additional css -->
    @stack('css')
</head>
<body>
    <div id="wrapper">
        <div class="main text-white min-vh-100">
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <x-application-logo alt="Brilio Logo" width="24" height="28" />
                    Guest Book
                </a>
                <span class="navbar-text">
                    <a class="text-decoration-none" href="{{ route('login') }}">Login</a>
                </span>
            </div>
        </nav>
            @yield('main')
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('gb-tmp/js/jquery.min.js') }}"></script>
    <script src="{{ asset('gb-tmp/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('a-tmp/plugins/toastr/toastr.min.js') }}"></script>
    @stack('js')
    @if(session()->exists('status_message'))
    <script type="text/javascript">
        toastr.success("{{ session()->get('status_message') }}");
    </script>
    @endif
</body>
</html>