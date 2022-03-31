@extends('dashboard.layout')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('dashboard.asset.index')}}">Assets</a></li>
    <li class="breadcrumb-item active">Создание</li>
@endsection

@section('content')

    {!! Form::open(['route' => [ 'dashboard.asset.store' ], 'method' => 'POST' ]) !!}

    <div class="row justify-content-md-center">

        <div class="col-8">

            <div class="card">

                <div class="card-body">
                    <span class="display-3 d-block mb-3 text-center">Asset: создание</span>

                    <div class="form-group">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('type', 'Type') !!}
                        {!! Form::select('type', trans('assets.types'), old('type'), ['class' => 'form-control', 'placeholder' => 'Type']) !!}
                    </div>

                    <div class="mb-3">
                        {!! Form::label('price_personal', 'Price Personal', ['class' => 'form-label']) !!}
                        {!! Form::text('price_personal', old('price_personal'), ['class' => 'form-control', 'placeholder' => 'Price']) !!}
                    </div>

                    <div class="mb-3">
                        {!! Form::label('price_commercial', 'Price Commercial', ['class' => 'form-label']) !!}
                        {!! Form::text('price_commercial', old('price_commercial'), ['class' => 'form-control', 'placeholder' => 'Price']) !!}
                    </div>

                    <div class="mb-3">
                        {!! Form::label('price_commercial_ext', 'Price Commercial Extended', ['class' => 'form-label']) !!}
                        {!! Form::text('price_commercial_ext', old('price_commercial_ext'), ['class' => 'form-control', 'placeholder' => 'Price']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('slug', 'Slug') !!}
                        {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => 'Slug']) !!}
                    </div>

                    <!-- jsonb -->


                    <div class="form-group">
                        {!! Form::label('status', 'Status') !!}
                        {!! Form::text('status', old('status'), ['class' => 'form-control', 'placeholder' => 'Status']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('position', 'Position') !!}
                        {!! Form::text('position', old('position'), ['class' => 'form-control', 'placeholder' => 'Position']) !!}
                    </div>

                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>

                </div>

            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection

@section('scripts')

@endsection
