@extends('mail.layout')


@section('content')

    <p style="font-size: 24px; font-weight: bold">Verify Your Email Address</p>


    <p>
        Please click the button below to verify your email address.
    </p>

    <div style="text-align: center; padding: 32px 0">
        <a href="{{route('website.user.verify_email', $hash)}}" style="font-size: 20px; display: inline-block; background: #fff; padding: 8px 16px; border: 1px solid #00CCA2; border-radius: 64px; color:#00CCA2;text-decoration: none;">Verify Email Address</a>
    </div>


    <p>
        Or use link: <br>

        <a href="{{route('website.user.verify_email', $hash)}}" style="color:#00CCA2;text-decoration: none;">{{route('website.user.verify_email', $hash)}}</a>
    </p>

    <p>
        If you did not create an account, no further action is required.
    </p>

@endsection