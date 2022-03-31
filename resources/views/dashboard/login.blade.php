<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <title>Вход</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #efefef;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>

</head>
<body class="text-center">
<form class="form-signin" method="post" action="/dashboard-login">
    @csrf
    <h1 class="h3 mb-3 font-weight-normal">Пожалуйста, войдите</h1>
    <label for="inputUsername" class="sr-only">Имя пользователя</label>
    <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Имя пользователя" required autofocus>
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Пароль" required>
    {{--    <div class="checkbox mb-3">--}}
    {{--        <label>--}}
    {{--            <input type="checkbox" value="remember-me"> Remember me--}}
    {{--        </label>--}}
    {{--    </div>--}}

    @error('credentials')

    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger small">{{ $message }}</div>
        </div>
    </div>

    @enderror

    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    <p class="mt-5 mb-3 text-muted">&copy;{{date('Y')}}</p>
</form>
</body>
</html>
