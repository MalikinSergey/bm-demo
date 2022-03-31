@extends('website.layout')

@section('page')

    <!-- register -->

    <div class="layer register-layer">
        <div class="container register-container">

            <div class="card-wrap">
                <div class="card">

                    @if($user)
                        <div class="card__header">
                            Email verification successfull!
                        </div>

                        <div>

                            <p>
                                Your email <b>{{$user->email}}</b> verified successfully.
                            </p>

                            @if(session()->get('from_url'))

                                <p>
                                    Now yoy can turn back to
                                    <a href="{{session()->get('from_url')}}" style="font-weight: bold; color: #282828;">{{session()->get('from_title')}}</a>

                                </p>

                            @endif

                        </div>
                    @else
                        <div class="card__header">
                            Email verification error &#128565;
                        </div>

                        <div>

                            <p>
                                We can't verify your email, because link you used is expired or invalid.
                            </p>

                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>
    </div>
    <!-- /register -->



@endsection
