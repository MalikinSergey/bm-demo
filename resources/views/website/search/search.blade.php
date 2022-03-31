@extends('website.layout')


@section('page')

    <!-- search -->

    <div class="layer search-layer">
        <div class="container search-container">

            <div class="search-search-bar">
                <form action="{{route('website.search.searching')}}" method="get" class="">

                    <input value="{{$realQuery}}" name="query" type="text" placeholder="search graphics" class="search hero__search" autocomplete="off">

                    <button type="submit" class="button button--primary button--l">Search</button>
                </form>
            </div>



            @if($icons->count())

                <h2>{{$icons->count()}} icons found by '{{$query}}'</h2>

                <div class="icons">

                    @foreach($icons as $asset)
                        <a href="{{route('website.asset.show', [$asset->family->slug, $asset->slug])}}" class="icon-preview icon-preview--search">
                            <img src="{{$asset->url()}}" alt="{{$asset->name}}">
                        </a>
                    @endforeach

                </div>

            @endif

            @if($iconPacks->count())

                <h2>{{$iconPacks->count()}} icon packs found by '{{$query}}'</h2>

                <div class="icons">

                    @foreach($iconPacks as $iconPack)
                        @include('components.pack', ['pack' => $iconPack])
                    @endforeach

                </div>

            @endif

            @if($illustrations->count())

                <h2>{{$illustrations->count()}} illustrations found by '{{$query}}'</h2>

                <div class="icons">

                    @foreach($illustrations as $asset)
                        <a href="{{route('website.asset.show', [$asset->family->slug, $asset->slug])}}" class="illustration-preview illustration-preview--search">
                            <img src="{{$asset->url()}}" alt="{{$asset->name}}">
                        </a>
                    @endforeach

                </div>

            @endif

            @if($illustrationPacks->count())

                <h2>{{$illustrationPacks->count()}} icon packs found by '{{$query}}'</h2>

                <div class="icons">

                    @foreach($illustrationPacks as $illustrationPack)
                        @include('components.pack', ['pack' => $illustrationPack])
                    @endforeach

                </div>

            @endif

            @if(!($icons->count()) && !$iconPacks->count() && !$illustrations->count() && !$illustrationPacks->count())

                <div class="search-no-results">
                    No icons or illustrations found by '{{$query}}'
                </div>

            @endif

        </div>
    </div>
    <!-- /search -->



@endsection
