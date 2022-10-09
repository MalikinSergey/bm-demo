@extends('website.layout')


@section('page')

    <div class="layer item-layer">
        <div class="container item-container">

            <div class="highlight">

                <div class="highlight__main">

                    <div class="highlight__info">

                        <a href="{{$family->url()}}" class="highlight__link">
                            <div class="highlight__title">{{$family->name}}</div>
                            <div class="highlight__subtitle">Full Family</div>

                            <div class="highlight__meta">
                                <b>{{$family->assets->count()}}</b> {{$family->getTypePlural()}}
                            </div>

                            <div class="highlight__meta">
                                <b>{{$family->packs->count()}}</b> packs
                            </div>
                        </a>

                        <div class="items-success">
                            @include('components.messages')
                        </div>

                        @if(user() && $family->hasLicense(auth()->user()))

                            <div class="item-download">

                                <div class="item-download__title">
                                    Click on button below to download purchased assets:
                                </div>

                                <a class="button button--primary" href="{{route('website.family.download', $family->slug)}}">Download ZIP with SVG and PNG assets</a>

                            </div>

                        @else
                            @include('website.item.components.formats')
                        @endif

                    </div>

                    <div class="highlight__assets">
                        @if($family->type === 'illustration')
                            <img src="{{$family->getCoverUrl()}}" class="highlight__cover" alt="{{$family->name}}">
                        @else
                            @foreach($family->assets()->orderByRaw("position asc nulls last")->take(8)->get() as $asset)
                                <img class="item-cover__icon" src="{{$asset->previewUrl(128)}}" alt="">
                            @endforeach
                        @endif
                    </div>

                </div>

                <div class="highlight__pricing">
                    {{Form::open(['method' => 'post', 'class' => 'pricing-form', 'route' => ['website.family.buy', $family->slug]])}}
                    @include('website.item.components.pricing', ['item' => $family])
                    {{Form::close()}}
                </div>

            </div>

            <family-show :family='{!! $family->toJson() !!}'></family-show>

        </div>
    </div>

@endsection
