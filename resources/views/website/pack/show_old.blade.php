@extends('website.layout')


@section('page')


    <div class="layer item-layer">
        <div class="container item-container">

            <div class="item">

                <div class="item-info">

                    <div class="item-name">
                        '{{$pack->name}}' pack from '{{$pack->family->name}}' family
                    </div>

                    <div class="item-desc">
                        Clean figures with soft corners and minimalistic details. Warm color pallete.
                    </div>

                    <div class="payment payment--centerize item__payment">

                        <div class="payment__price payment__price--centerized">${{$pack->price}}</div>

                        <div class="payment__options">
                            <a href="#" class="button button--primary payment__buy">Buy Now</a>
                            <div class="payment__or">or</div>
                            <a href="#" class="payment__subscribe">
                                Subscribe $19 / month <br>
                                for full access
                            </a>
                        </div>

                    </div>

                </div>

            </div>

            <div class="assets-title assets-title--centerize">
                {{$assets->count()}} icons
            </div>

            <div class="icons">

                @foreach($assets as $asset)
                    <a href="{{route('website.asset.show', [$asset->family->slug, $asset->slug])}}" class="icon">
                        <img src="{{$asset->url()}}" alt="{{$asset->name}}">
                    </a>
                @endforeach

            </div>

        </div>
    </div>

@endsection
