<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>City News | Admin Panel</title>
    <!-- Bootstrap -->
    {{-- <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/css/font-awesome.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <div class="container-fluid">
        <div id="header-admin">
            <div class="main-header">
                <a href="/"><img class="logo" src="{{ asset('admin/images/bg_none_logo.png') }}"></a>
                <div class="profile-header">
                    <h4>Nadim Ahmad</h4>
                    <div class="logout-btn">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="admin-logout btn btn-sm"><i class="fa fa-sign-in"></i> Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Bar -->
        <div id="admin-menubar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="admin-menu">
                            <li><a class="{{ request()->is('posts') ? 'active' : '' }}" href="{{ route('posts.index') }}">Post</a></li>
                            <li><a class="{{ request()->is('category') ? 'active' : '' }}" href="{{ route('category.index') }}">Category</a></li>
                            <li><a class="{{ request()->is('users') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a></li>
                            <li><a class="{{ request()->is('settings') ? 'active' : '' }}" href="{{ route('settings.index') }}">Website settings</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div id="footer">
            <div class="row">
                <div class="col-md-12">
                    <span>&copy; All Rights Reserved City News <script>document.write(new Date().getFullYear())</script> | Nadim Ahmad</span>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    {{-- <script src="{{ asset('admin/js/jquery.js') }}"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap Bundle -->
    {{-- <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Custom Scripts -->
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
        };

        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
    @stack('scripts')
</body>
</html>