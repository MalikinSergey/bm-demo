@extends('website.layout')


@section('page')


    <div class="layer families-layer">
        <div class="container families-container">


            <div class="families-title">Families</div>

            <div class="families-welcome">


                We group our illustrations and icons into families. By color, idea, or just according to our imagination.

                <br>
                On this page you can see all our families
                and go to each of them for a detailed view.


            </div>

            <div class="families">

                @foreach($families as $family)

                    @if($family->type === 'icon')
                        @include('components.highlight_icons' ,['family' => $family])

                    @else
                        @include('components.highlight_illustrations' ,['family' => $family])

                    @endif


                @endforeach


            </div>
        </div>
    </div>

@endsection
