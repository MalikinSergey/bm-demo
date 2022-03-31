<a href="{{$pack->url()}}" class="pack">

    <div class="pack__assets pack__assets--{{$pack->family->type}}">

        @foreach($pack->assets()->take($pack->family->type === 'icon' ? 6 : 1)->get() as $asset)

            <div class="pack__asset pack-{{$pack->family->type}}-preview">

                <img src="{{$asset->previewUrl($pack->family->type === 'icon' ? 86 : 320)}}" alt="{{$asset->name}}">

            </div>

        @endforeach

    </div>

    <div class="pack__name">

        {{$pack->name}}

    </div>

    <div class="pack__info">

        <div class="pack__count">

            @if($pack->family->type === 'icon')
                {{trans_choice(':count icon|:count icons', $pack->assets->count())}}
            @else
                {{trans_choice(':count illustration|:count illustrations', $pack->assets->count())}}
            @endif

        </div>

        <div class="pack__price">
            from <span class="pack-price-value">${{$pack->getPrice('personal')}}</span>
            <span class="pack-price-discount">save {{$pack->getDiscountPercent()}}%</span>
        </div>

    </div>

</a>
