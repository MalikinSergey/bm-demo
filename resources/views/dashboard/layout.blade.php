<!doctype html>
<html lang="en">

<head>
    <title>
        @section('title')
            BoykoMarket - Dashboard
        @show
    </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="/dash/css/dashboard.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        })
    </script>


</head>

<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">BoykoMarket - Dashboard</a>
</header>

<div class="container-fluid">

    <div class="row">

        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <nav class="position-sticky pt-3">
                @include('dashboard.main_menu')
            </nav>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-4">

            <nav aria-label="breadcrumb" role="navigation" class="mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    @yield('breadcrumbs')
                </ol>
            </nav>

            {{-- messages --}}
            <div class="row mt-3">
                <div class="col">
                    @if(Session::get('message'))
                        <div class="alert alert-success animated fadeIn" role="alert">{{trans(Session::get('message'))}}</div>
                    @endif

                    @if(($errors ?? new \Illuminate\Support\MessageBag())->count())
                        <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $msg)
                                <p>{{trans($msg)}}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            {{-- /messages --}}

            @yield('content')

        </main>

    </div>

</div>


@yield('scripts')

<script type="text/javascript">
    $(function () {

        $('.btn-danger').on('click', function (e) {

            if (confirm('Please confirm action')) {
                //
            }
            else {
                e.preventDefault()
            }

        })

    })
</script>


</body>
</html>
