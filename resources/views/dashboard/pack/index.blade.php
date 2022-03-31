@extends('dashboard.layout')

@section('breadcrumbs')

    <li class="breadcrumb-item">
        <a href="{{route('dashboard.family.index')}}">Families</a>
    </li>
    <li class="breadcrumb-item active">{{$family->name}}: {{$family->packs->count()}} packs</li>
@endsection

@section('content')


    {{--top--}}

    <div class="h2 mb-3">{{$family->name}}: {{$family->packs->count()}} packs</div>

    <div class="mb-3">
        <a href="{{route('dashboard.pack.create', ['family_id' => $family->id])}}" class="btn btn-success">Add new pack</a>
    </div>

    {{--/top--}}

    <hr>

    <div class="row">

        <div class="col">

            <div class="row">
                <div class="col-12">

                    @foreach($family->packs as $pack)

                        <div class="d-flex align-items-center">
                            <div class="p-1">
                              <span class="h4">{{$pack->name}} ({{$pack->assets->count()}} assets)</span>
                            </div>

                            <div class="p-1">
                                <a href="{{$pack->url()}}" class="btn btn-sm btn-success">open</a>
                            </div>
                            <div class="p-1">
                                <a href="{{route('dashboard.pack.edit', [$pack->id])}}" class="btn btn-sm btn-primary">edit pack info</a>
                            </div>
                            <div class="p-1">
                                <a href="{{route('dashboard.asset.edit_multiple', ['pack_id' => $pack->id])}}" class="btn btn-sm btn-primary">edit assets</a>
                            </div>
                            <div class="p-1">
                                {!! Form::open(['route' => [ 'dashboard.pack.destroy', $pack->id], 'method' => 'delete', 'style' => 'display:inline-block'  ]) !!}
                                {!! Form::submit('destroy pack', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12">

                                <div class="row g-1">

                                    @foreach($pack->assets as $asset)
                                        <div class="col-2">
                                            <img class="img-fluid" src="{{$asset->url()}}" alt="{{$asset->name}}">
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <hr>

                    @endforeach

                </div>

            </div>

        </div>

    </div>



@endsection


@section('scripts')


@endsection
