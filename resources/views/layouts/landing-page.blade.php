<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') | SIMPERPUS</title>

    @include('includes.auth.style')
    @stack('style')

</head>

<body>

    <div class="container">
        @yield('content')
    </div>

    @include('includes.auth.script')
    @stack('script')

</body>

</html>