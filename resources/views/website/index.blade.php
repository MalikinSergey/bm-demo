@extends('website.layout')

@section('page')


    <div class="layer">

        <div class="container">
            <div class="hero">
                <div class="hero-content">

                    <div class="hero-title">
                        Icons and illustrations
                        for all purposes
                    </div>

                    <div class="index-title">
                        Exclusive icons and illustrations packs. <br>
                        One icon, thematic set or full graphic family &mdash; choose your own.
                    </div>

                    <div class="hero-search-bar">
                        <form action="{{route('website.search.searching')}}" method="get" class="">

                            <input name="query" type="text" placeholder="search graphics" class="search hero__search" autocomplete="off">

                            <button type="submit" class="button button--primary button--l">Search</button>
                        </form>
                    </div>

                </div>



{{--                <a href="#" class="premium-offer">--}}

{{--                    <div class="premium-offer__title">--}}
{{--                        Unlimited access <br>--}}
{{--                        for all icons <br>--}}
{{--                        and illustrations <br>--}}
{{--                    </div>--}}

{{--                    <div class="premium-offer__price">--}}
{{--                        $8.99--}}
{{--                    </div>--}}

{{--                    <div class="premium-offer__hint">--}}
{{--                        /month--}}
{{--                    </div>--}}

{{--                    <div class="premium-offer__name">--}}
{{--                        Premium Plan--}}
{{--                    </div>--}}
{{--                </a>--}}

            </div>



            <div class="highlights">

                @foreach($landingFamilies as $landingFamily)

                    @include('components.highlight_icons' ,['family' => $landingFamily])

                @endforeach

                <a href="{{route('website.family.index')}}" class="highlights__more">Explore more</a>

            </div>

            <div class="landing-packs">
                <div class="icons">

                    @foreach($landingPacks as $pack)
                        @include('components.pack')
                    @endforeach

                </div>

                <div style="text-align: center; margin-bottom: 80px;">
                    <a href="{{route('website.family.index')}}" class="highlights__more">Explore more</a>

                </div>
            </div>

        </div>
    </div>


@endsection
