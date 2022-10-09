@extends('dashboard.layout')

@section('breadcrumbs')

    <li class="breadcrumb-item"><a href="{{route('dashboard.family.index', ['type' => $family->type])}}">{{$family->type}}s</a></li>
    <li class="breadcrumb-item active">{{$family->name}}</li>
@endsection

@section('content')


    <div class="row">

        <div class="col">


            <span class="display-3 d-block mb-3 ">{{$family->name}}</span>

            <div class="row">
                <div class="col-4">

                    <div class="card">

                        <div class="card-body">

                            @if($family->hasCover())
                                <img src="{{$family->getCoverUrl()}}" alt="" class="img-fluid img-thumbnail mb-4">
                            @endif

                            {!! Form::model($family, ['route' => [ 'dashboard.family.update', $family->id ], 'method' => 'PUT', 'files' => true ]) !!}

                            <div class="mb-3">
                                {!! Form::label('cover', 'Cover', ['class' => 'form-label']) !!}
                                {!! Form::file('cover',  ['class' => 'form-control', 'placeholder' => 'cover']) !!}
                            </div>

                            <div class="mb-3">
                                {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                                {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                            </div>

                            <div class="mb-3">
                                {!! Form::label('type', 'Type', ['class' => 'form-label']) !!}
                                {!! Form::select('type', trans('families.types'), old('type'), ['class' => 'form-select', 'placeholder' => 'Type']) !!}
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
                                {!! Form::label('status', 'Status', ['class' => 'form-label']) !!}
                                {!! Form::select('status', trans('families.statuses'), old('status'), ['class' => 'form-select']) !!}
                            </div>

                            <div class="mb-3">
                                {!! Form::label('position', 'Position', ['class' => 'form-label']) !!}
                                {!! Form::text('position', old('position'), ['class' => 'form-control', 'placeholder' => 'Position']) !!}
                            </div>

                            <div class=" mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                            {!! Form::close() !!}

                        </div>


                    </div>

                </div>
                <div class="col-4">

{{--
                    <div class="card">

                        <div class="card-body">

                            {!! Form::open(['route' => [ 'dashboard.asset.update_multiple_prices', ['family_id' => $family->id] ], 'method' => 'POST' ]) !!}


                            {{Form::hidden('family_id', $family->id)}}

                            <div class="mb-3">
                                {!! Form::label('price_personal', 'Set Asset Price Personal', ['class' => 'form-label']) !!}
                                {!! Form::text('price_personal', old('price_personal'), ['class' => 'form-control', 'placeholder' => 'Price']) !!}
                            </div>

                            <div class="mb-3">
                                {!! Form::label('price_commercial', 'Set Asset Price Commercial', ['class' => 'form-label']) !!}
                                {!! Form::text('price_commercial', old('price_commercial'), ['class' => 'form-control', 'placeholder' => 'Price']) !!}
                            </div>

                            <div class="mb-3">
                                {!! Form::label('asset_price_commercial_ext', 'Set Asset Price Commercial Extended', ['class' => 'form-label']) !!}
                                {!! Form::text('price_commercial_ext', old('price_commercial_ext'), ['class' => 'form-control', 'placeholder' => 'Price']) !!}
                            </div>

                            <div class=" mb-3">
                                <button type="submit" class="btn btn-primary">Set prices for all assets in family</button>
                            </div>

                            {!! Form::close() !!}


                        </div>


                    </div>
--}}

                </div>

                <div class="col-4">

                    <div class="card">

                        <div class="card-body">


                            {{Form::open(['route' => 'dashboard.asset.store_multiple', 'method' => 'post', 'files' => 'true'])}}


                            {{Form::hidden('family_id', $family->id)}}


                            <div class="mb-3">
                                {{Form::file('assets[]', ['multiple'])}}

                            </div>

                            <div class=" mb-3">
                                <button type="submit" class="btn btn-primary">Upload assets</button>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection


@section('scripts')


@endsection
