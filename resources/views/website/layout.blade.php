<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Boyko Market</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    {{--
        <meta property="og:title" content="">
        <meta property="og:type" content="">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
    --}}

    {{--    <link rel="manifest" href="site.webmanifest">--}}
    {{--    <link rel="apple-touch-icon" href="/icon.png">--}}


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oxygen+Mono&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Nunito, sans-serif;
            color: #333;
        }

        .preload *, .preload *::placeholder, .preload *::before, .preload *::after {
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -ms-transition: none !important;
            -o-transition: none !important;
        }

    </style>

    <link rel="stylesheet" href="/website/css/app.css?{{filemtime(public_path('website/css/app.css'))}}">

    <meta name="theme-color" content="#ffffff">

    {{--icon--}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel=”mask-icon” href=”/favicon-mask.svg color=”#00CCA2">

    <link rel="apple-touch-icon" href="/favicon-180.png">
    <meta name="theme-color" content="#00CCA2">
    <link rel="manifest" href="/manifest.webmanifest">




</head>

<body class="preload">

<div class="layer header-layer">
    <div class="container header">
        <a href="/" class="logo-link header__logo">
            @include('components.logo')
        </a>

        <div class="menu">
            <a href="{{route('website.family.index')}}">Icons families</a>
            <a href="{{route('website.family.illustrations')}}">Illustrations</a>
        </div>

        <form action="{{route('website.search.searching')}}" method="get" class="header__search-form">
            <input type="text" placeholder="search graphics" class="search header__search" name="query" autocomplete="off">
        </form>

        @if(auth()->check())
           <div class="header__user">
               {{auth()->user()->email}}
               <form  class="logout-form" action="{{route('website.user.logout')}}" method="post">
                   @csrf
                   <button type="submit" class="button button--primary button--xs">logout</button>
               </form>
           </div>
        @else

            <a href="#" class="button button--primary-outline header__sign-in mr-8">Sign in</a>

            <div class="bm-form-glue  mr-8">or</div>

            <a class="bm-link" href="{{route('website.user.register')}}">register</a>

            @include('website.components.login')

        @endif


    </div>
</div>

@section('page')

@show

<div class="layer footer-layer">
    <div class="container footer">

        <div class="credits">
            <a href="/" class="logo-link credits__logo">
                @include('components.logo-white')
            </a>

            <div class="copyright">
                Copyright &copy; 2020-{{date('Y')}} Boyko Market. <br>
                All rights reserved. <br>

            </div>

        </div>

        <div class="footer-links">

            <div class="footer-links__block">
                <div class="footer-links__title">Graphics</div>
                <a href="#">Icons</a>
                <a href="#">Illustrations</a>
            </div>

            <div class="footer-links__block">
                <div class="footer-links__title">Help & Support</div>
                <a href="{{route('website.legal.terms')}}">Terms & Conditions</a>
                <a href="{{route('website.legal.delivery')}}">Delivery Policy</a>
                <a href="{{route('website.legal.privacy')}}">Privacy policy</a>
                <a href="{{route('website.legal.payments')}}">Payments rules</a>
                <a href="{{route('website.legal.refunds')}}">Return & Refund Policy</a>
                <a href="{{route('website.legal.licenses')}}">Licenses</a>

            </div>

            <div class="footer-links__block">
                <div class="footer-links__title">Company</div>

                <a href="{{route('website.about')}}">About</a>
                <a href="{{route('website.contact.form')}}">Contact us</a>

                <a href="https://boyko.pictures">Boyko.pictures</a>

            </div>

        </div>


    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(function () {

    $('body').removeClass('preload')

    $('.header__sign-in').click(function (e) {

      e.preventDefault()

      $('.login-card').fadeIn(300)

    })


    $(document).on('click', function(event) {
      if (!$(event.target).closest('.login-card, .header__sign-in').length) {
        $('.login-card').fadeOut(300)
      }
    });


  })

</script>

@stack('scripts')

</body>

</html>
