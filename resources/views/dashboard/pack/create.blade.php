@extends('dashboard.layout')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('dashboard.pack.index')}}">Packs</a>
    </li>
    <li class="breadcrumb-item active">Создание</li>
@endsection

@section('content')

    {!! Form::open(['route' => [ 'dashboard.pack.store' ], 'method' => 'POST' ]) !!}

    {{Form::hidden('family_id', request('family_id'))}}

    <div class="row justify-content-md-center">

        <div class="col-8">

            <div class="card">

                <div class="card-body">
                    <span class="display-3 d-block mb-3 text-center">Adding new pack</span>

                    <div class="mb-3">
                        {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
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

                    <div class="mb-3">
                        {!! Form::label('slug', 'Slug', ['class' => 'form-label']) !!}
                        {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => 'Slug']) !!}
                    </div>

                    <div class="mb-3">
                        {!! Form::label('purpose', 'Freebie or paid?', ['class' => 'form-label']) !!}
                        {!! Form::select('purpose', ['paid' => 'Paid', 'freebie' => 'Freebie'], old('status'), ['class' => 'form-select']) !!}
                    </div>

                    <div class="mb-3">
                        {!! Form::label('status', 'Status', ['class' => 'form-label']) !!}
                        {!! Form::select('status', trans('packs.statuses'), old('status'), ['class' => 'form-select', 'placeholder' => 'Status']) !!}
                    </div>

                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-primary">Add new pack</button>
                    </div>

                </div>

            </div>

        </div>
    </div>

    {!! Form::close() !!}

@endsection

@section('scripts')

@endsection
