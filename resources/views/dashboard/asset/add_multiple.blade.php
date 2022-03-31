@extends('dashboard.layout')

@section('breadcrumbs')

    <li class="breadcrumb-item"><a href="{{route('dashboard.family.index')}}">Families</a></li>
    <li class="breadcrumb-item active">{{$family->name}}</li>
    <li class="breadcrumb-item active">Add multiple assets</li>
@endsection

@section('content')


    <div class="row">

        <div class="col">


            <span class="h1 d-block mb-3 ">{{$family->name}}</span>

            <div class="row">


                <div class="col-6">

                    <div class="card">

                        <div class="card-body">

                            <span class="h3 d-block mb-3 ">Upload new assets to family</span>



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
