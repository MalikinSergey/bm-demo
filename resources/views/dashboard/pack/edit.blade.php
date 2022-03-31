@extends('dashboard.layout')

@section('breadcrumbs')

    <li class="breadcrumb-item">
        <a href="{{route('dashboard.pack.index', ['family_id' => $pack->family_id])}}">Packs of {{$pack->family->name}}</a>
    </li>
    <li class="breadcrumb-item active">{{$pack->name}}</li>
@endsection

@section('content')

    {!! Form::model($pack, ['route' => [ 'dashboard.pack.update', $pack->id ], 'method' => 'PUT' ]) !!}

    <div class="row">

        <div class="col-6">

            <div class="card">

                <div class="card-body">
                    <span class="display-3 d-block mb-3 ">{{$pack->name}}</span>

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

                    <!-- jsonb -->
                    <div class="mb-3">
                        {!! Form::label('status', 'Status', ['class' => 'form-label'], ['class' => 'form-label']) !!}
                        {!! Form::select('status', trans('families.statuses'), old('status'), ['class' => 'form-select', 'placeholder' => 'Status']) !!}
                    </div>


                    <div class=" mb-3">
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
