@extends('dashboard.layout')

@section('breadcrumbs')

    <li class="breadcrumb-item"><a href="{{route('dashboard.tag.index')}}">Tags</a></li>
    <li class="breadcrumb-item active">{{$tag->name}}</li>
@endsection

@section('content')

    {!! Form::model($tag, ['route' => [ 'dashboard.tag.update', $tag->id ], 'method' => 'PUT' ]) !!}

    <div class="row justify-content-md-center">

        <div class="col-8">

            <div class="card">

                <div class="card-body">
                    <span class="display-3 d-block mb-3 text-center">{{$tag->name}}</span>

                    <div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
</div>

<div class="form-group">
    {!! Form::label('slug', 'Slug') !!}
    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => 'Slug']) !!}
</div>

<!-- jsonb -->


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
