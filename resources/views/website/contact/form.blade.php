@extends('website.layout')


@push('scripts')

    <script src="https://www.google.com/recaptcha/api.js"></script>


    <script>
      function onSubmit(token) {
        document.getElementById("contact-form").submit();
      }
    </script>
@endpush

@section('page')

    <!-- register -->

    <div class="layer register-layer">
        <div class="container register-container">

            <div class="card-wrap">

                <div class="card contact-card">

                    <div class="card__header card__header--contact">
                        Contact us
                    </div>

                    <div>

                        <p class="contact-tagline">
                            If you have any questions about the shop,
                            write to us via this contact form or email us at contact@boykomarket.com. <br>
                            We’ll reply as soon as possible!
                        </p>

                        <form action="{{route('website.contact.send')}}" method="post" id="contact-form">

                            @csrf

                            @include('components.messages')

                            <div class="bm-form-group">

                                <div class="bm-label">Your name</div>

                                <input type="text" class="bm-input-text bm-input-text--long" name="name" value="{{old('email')}}">

                            </div>

                            <div class="bm-form-group">

                                <div class="bm-label">Your E-mail</div>

                                <input type="text" class="bm-input-text bm-input-text--long" name="email" value="{{old('email')}}">

                            </div>

                            <div class="bm-form-group">

                                <div class="bm-label mb-8">Your message or question</div>

                                <textarea class="bm-textarea bm-input-text--long" name="message">{{old('message')}}</textarea>

                            </div>

                            <div class="bm-button-group bm-button-group--line mt-32">

                                <button class="button button--primary g-recaptcha"
                                        data-sitekey="6LdtgAoeAAAAAJpbwWWi4_0d6cNbMe0ZrCrjNnr4"
                                        data-callback='onSubmit'
                                        data-action='submit' type="submit">
                                    Send message
                                </button>

                            </div>

                        </form>

                    </div>

                    <div class="contact-letter">
                        <p><b>Also you can also send a letter to us at: </b></p>

                        <p>
                            <i>
                                Individual Entrepreneur Ilia Boiko, <br>
                                Zipcode: 173004 <br>
                                Russian Federation, Velikiy Novgorod, <br>
                                Gerasimenko-Manitsyna, 26k1 apt. 79
                            </i>

                        </p>

                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
    <!-- /register -->



@endsection
