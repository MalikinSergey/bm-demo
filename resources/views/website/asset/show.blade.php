@extends('website.layout')

@section('page')

    <div class="layer item-layer">

        <div class="container item-container">

            <div class="item item--illustrated item--{{$asset->type}}">

                <div class="item-cover">

                    <div class="item-cover__main item-cover__main--{{$asset->type}}">
                        <img src="{{$asset->previewUrl($asset->type === 'icon' ? 320 : 512)}}" alt="{{$asset->name}}">
                    </div>

                </div>

                <div class="item-info">

                    <div class="item-name">
                        {{$asset->getName()}}
                    </div>

                    <div class="item-from">
                        from
                        <a href="{{$asset->family->url()}}">{{$asset->family->name}}</a>
                        family
                    </div>

                    @if($asset->hasLicense(auth()->user()))

                        <div class="item-download">

                            <div class="item-download__title">
                                Click on button below to download purchased assets:
                            </div>

                            <a class="button button--primary" href="{{route('website.asset.download', [$asset->family->slug, $asset->slug])}}">Download ZIP with SVG and PNG assets</a>

                        </div>

                    @else

                        @include('website.item.components.formats')

                    @endif

                    <div class="items-success">
                        @include('components.messages')

                    </div>

                    {{--                    @if($asset->tags->count())--}}
                    {{--                        <div class="item-tags">--}}

                    {{--                            @foreach($asset->tags as $tag)--}}
                    {{--                                <div class="tag-badge">{{$tag->name}}</div>--}}
                    {{--                            @endforeach--}}

                    {{--                        </div>--}}
                    {{--                    @endif--}}

                    <div class="item-pricing">
                        <div class="pricing">
                            {{Form::open(['method' => 'post', 'route' => ['website.asset.buy', [$asset->family->slug, $asset->slug]]])}}
                            @include('website.item.components.pricing', ['item' => $asset])
                            {{Form::close()}}
                        </div>
                    </div>

                </div>

            </div>

            @if($asset->packs->count())
                <div class="item-related-title">
                    {{trans_choice(':count pack|:count packs', $asset->packs->count())}}
                    contains this asset:
                </div>

                <div class="icons">

                    @foreach($asset->packs as $pack)
                        @include('components.pack')
                    @endforeach

                </div>

            @endif

        </div>

    </div>

@endsection
