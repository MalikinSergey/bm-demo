@extends('website.layout')

@section('page')

    <!-- register -->

    <div class="layer register-layer">
        <div class="container register-container">

            <div class="card-wrap">
                <div class="card">

                    <div class="card__header">
                        Thanks for signing up!
                    </div>

                    <div>

                        <p>Before getting started, could you verify your email address by clicking on the link we just emailed to you? </p>
                        <p>This link is valid for next 24 hours.</p>
                        <p> If you didn't receive the email, we will gladly send you another.</p>

                        {{--                         A new verification link has been sent to the email address you provided during registration.--}}
                        {{--                         Resend Verification Email--}}

                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
    <!-- /register -->



@endsection
