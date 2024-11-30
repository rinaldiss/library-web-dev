<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') | SIMPERPUS</title>

    @include('includes.admin.style')
    @stack('style')

</head>

<body id="page-top">
    <div id="wrapper">

        @include('includes.admin.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                @include('includes.admin.navbar')

                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>

            @include('includes.admin.footer')

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('includes.admin.script')
    @stack('script')

</body>

</html>