<div class="pricing-main">

    <div class="pricing__info">

        <div class="pricing__title">License Type</div>

        <div class="pricing__licenses">

            @if($item->hasLicense(auth()->user(), 'commercial'))

                <label class="pricing__license">

                    <div class="pricing__control">

                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#00CCA2" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                        </svg>

                    </div>

                    <div class="pricing__name">
                        <div class="pricing__exact">
                            Commercial
                        </div>
                        <div class="pricing__hint">
                            up to 7k end products for sale or 300k unique visitors per month
                        </div>
                    </div>

                    <div class="pricing__value pricing__value--hide">${{$item->getPrice('commercial')}}</div>

                </label>

            @else
                <label class="pricing__license">

                    <div class="pricing__control">

                        <input type="radio" name="license_type" value="commercial" checked>

                    </div>

                    <div class="pricing__name">
                        <div class="pricing__exact">
                            Commercial
                        </div>
                        <div class="pricing__hint">
                            up to 7k end products for sale or 300k unique visitors per month
                        </div>
                    </div>

                    <div class="pricing__value">${{$item->getPrice('commercial')}}</div>

                </label>
            @endif

            @if($item->hasLicense(auth()->user(), 'personal'))

                <label class="pricing__license">

                    <div class="pricing__control">

                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#00CCA2" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                        </svg>

                    </div>

                    <div class="pricing__name">
                        <div class="pricing__exact">
                            Personal
                        </div>
                        <div class="pricing__hint">
                            for personal or non-commercial projects
                        </div>
                    </div>

                    <div class="pricing__value pricing__value--hide">${{$item->getPrice('personal')}}</div>

                </label>

            @else

                <label class="pricing__license">

                    <div class="pricing__control">

                        <input type="radio" name="license_type" value="personal">

                    </div>

                    <div class="pricing__name">
                        <div class="pricing__exact">
                            Personal
                        </div>
                        <div class="pricing__hint">
                            for personal or non-commercial projects
                        </div>
                    </div>

                    <div class="pricing__value">${{$item->getPrice('personal')}}</div>

                </label>

            @endif


            @if($item->hasLicense(auth()->user(), 'commercial_ext'))

                <label class="pricing__license">

                    <div class="pricing__control">

                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="#00CCA2" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                        </svg>

                    </div>

                    <div class="pricing__name">
                        <div class="pricing__exact">
                            Commercial Extended
                        </div>
                        <div class="pricing__hint">
                            up to 1m end products for sale or 10m unique visitors per month
                        </div>
                    </div>

                    <div class="pricing__value pricing__value--hide">${{$item->getPrice('commercial_ext')}}</div>

                </label>

            @else

                <label class="pricing__license">

                    <div class="pricing__control">

                        <input type="radio" name="license_type" value="commercial_ext">

                    </div>

                    <div class="pricing__name">

                        <div class="pricing__exact">
                            Commercial Extended
                        </div>

                        <div class="pricing__hint">
                            up to 1m end products for sale or 10m unique visitors per month
                        </div>

                    </div>
                    <div class="pricing__value">${{$item->getPrice('commercial_ext')}}</div>

                </label>
            @endif

        </div>

{{--        <div class="pricing__more">more options</div>--}}

    </div>

    <div class="pricing__actions">

        <button type="submit" class="button button--primary button--l">Buy Now</button>

    </div>

</div>
