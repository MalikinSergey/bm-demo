@extends('mail.layout')


@section('content')

    <p style="font-size: 24px; font-weight: bold">Сообщение из формы контакта boykomarket.com</p>

    <p>
        Имя: {{data_get($data, 'name')}}
    </p>
    <p>
        Почта: {{data_get($data, 'email')}}
    </p>
    <p>
        Сообщение:
    </p>

    <p>
        {{data_get($data, 'message')}}
    </p>

@endsection