@if(Session::get($key ?? 'message'))
    <div class="bm-success" role="alert">{{trans(Session::get($key ?? 'message'))}}</div>
@endif


@if($errors->count())
    <div class="bm-errors" role="alert">
        @foreach($errors->all() as $msg)
            <p>{{trans($msg)}}</p>
        @endforeach
    </div>
@endif
