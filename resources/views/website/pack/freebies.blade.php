@extends('website.layout')


@section('page')


    <div class="layer families-layer">
        <div class="container families-container">


            <div class="families-title">Freebies</div>

            <div class="families-welcome">


                <p>
                    Here we place a little bit of our works, that we want to give to the world from the bottom of our hearts.
                    <br>
                    You can use it absolutly free, for both personal and commercial purposes.
                </p>


            </div>


            <div class="packs">

                @foreach($packs as $pack)
                    @include('components.pack')
                @endforeach

            </div>

        </div>
    </div>

@endsection
