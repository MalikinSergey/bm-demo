@extends('dashboard.layout')

@section('breadcrumbs')



@endsection


@section('content')


    <div class="h1">
            Hello!


    </div>
    <div>
        <p>
            PHP: {{phpversion()}}
        </p>  <p>
            Laravel: {{app()->version()}}
        </p>
    </div>

@endsection


