<div class="highlight">
    <div class="highlight__main">

        <div class="highlight__info">

            <a href="{{$family->url()}}" class="highlight__link">
                <div class="highlight__title">{{$family->name}}</div>
                <div class="highlight__meta">
                    <b>{{$family->assets->count()}}</b> {{$family->getTypePlural()}}
                </div>

                @if($family->packs->count())

                    <div class="highlight__meta">
                        <b>{{$family->packs->count()}}</b> packs
                    </div>
                @endif

            </a>

            <div class="item-formats">
                <span>zip</span>
                <span>svg</span>
                <span>png</span>
            </div>

            <div class="highlight__buy">
                <a href="{{$family->url()}}" class="button button--primary button--l">
                    <span>Buy now</span>
                    <span class="button__divider"></span>
                    <span class="highlight__price">from ${{$family->getPrice('personal')}}</span>
                </a>
            </div>

        </div>

        <a href="{{$family->url()}}" class="highlight__illustration">

            <img src="{{$family->getCoverUrl()}}" alt="">

        </a>

    </div>
</div>
