@extends('website.layout')


@section('page')


    <div class="layer item-layer">
        <div class="container item-container">

            <div class="item">

                <div class="item-cover">

                    <div class="item-cover__main item-cover__main--{{$pack->type}}">

                        @if($pack->type === 'illustration')
                            <img src="{{$pack->assets()->orderByRaw("position asc nulls last")->take(1)->first()->url()}}" alt="{{$pack->name}}">
                        @else
                            @foreach($pack->assets()->orderByRaw("position asc nulls last")->take(9)->get() as $asset)
                                <img class="item-cover__icon" data-id="{{$asset->id}}" src="{{$asset->previewUrl(128)}}" alt="">
                            @endforeach
                        @endif

                    </div>

                    <div class="item-cover__title item-cover__title--{{$pack->type}}">
                        {{$pack->name}} Pack: <span>{{$pack->assets()->count()}} {{$pack->getTypePlural()}}</span>
                    </div>

                </div>

                <div class="item-info">

                    <div class="item-title">
                        <div class="item-name">
                            {{$pack->name}}
                        </div>

                        <div class="item-from">
                            {{\Stringy\StaticStringy::upperCaseFirst($pack->family->getTypePlural())}} pack from
                            <a class="bm-link" href="{{$pack->family->url()}}">{{$pack->family->name}}</a>
                                                                                                       family
                        </div>

                        @if($pack->hasLicense(auth()->user()))

                            <div class="item-download">

                                <div class="item-download__title">
                                    Click on button below to download purchased assets:
                                </div>

                                <a class="button button--primary" href="{{route('website.pack.download', [$pack->family->slug, $pack->slug])}}">Download ZIP with SVG and PNG assets</a>

                            </div>

                        @else

                            @include('website.item.components.formats')

                        @endif

                    </div>

                    <div class="items-success">
                        @include('components.messages')

                    </div>

                    <div class="item-pricing">
                        <div class="pricing">
                            {{Form::open(['method' => 'post', 'route' => ['website.pack.buy', [$pack->family->slug, $pack->slug]]])}}
                            @include('website.item.components.pricing', ['item' => $pack])
                            {{Form::close()}}
                        </div>
                    </div>

                </div>

            </div>

            <div class="assets-title">
                @if($pack->family->type === 'icon')
                    {{trans_choice(':count icon|:count icons', $assets->count())}}
                @else
                    {{trans_choice(':count illustration|:count illustrations', $assets->count())}}
                @endif
            </div>

            <div class="icons">

                @foreach($assets as $asset)
                    <a href="{{route('website.asset.show', [$asset->family->slug, $asset->slug])}}" class="{{$pack->family->type}}-preview">
                        <img src="{{$asset->previewUrl($asset->family->type === 'illustration' ? 512 : 128)}}" alt="{{$asset->name}}">
                    </a>
                @endforeach

            </div>

        </div>
    </div>

@endsection
