@extends('dashboard.layout')

@section('breadcrumbs')

    <li class="breadcrumb-item">
        <a href="{{route('dashboard.family.index')}}">Families</a>
    </li>
    <li class="breadcrumb-item active">{{$family->name}}</li>
@endsection

@section('content')


    <div class="row">

        <div class="col">

            <span class="display-3 d-block mb-3 ">{{$family->name}}</span>

            <div class="row">

                <div class="col-6">

                    <div class="card">

                        <div class="card-body">

                            <h3 class="card-title">{{$family->uploads->count()}} uploads</h3>

                            <hr>

                            @foreach($family->uploads as $upload)


                                <div class="d-flex mb-2">

                                    <div class="me-2 h5">
                                        {{$upload->assets->count()}} assets at {{$upload->created_at->format('Y-m-d H:i')}}
                                    </div>

                                    <a href="{{route('dashboard.asset.edit_multiple', ['upload_id' => $upload->id])}}" class="btn btn-primary btn-sm ms-auto">edit assets</a>

                                </div>

                                <div class="row">

                                    <div class="col-12">

                                        <div class="row g-1">

                                            @foreach($upload->assets as $asset)
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

                <div class="col-6">

                    <div class="card">

                        <div class="card-body">
                            <h3 class="card-title">{{$family->packs->count()}} packs</h3>

                            <hr>

                            @foreach($family->packs as $pack)


                                <div class="d-flex mb-2">

                                    <div class="me-2 h5">
                                        {{$pack->name}}
                                    </div>

                                    <a href="{{route('dashboard.asset.edit_multiple', ['pack_id' => $pack->id])}}" class="btn btn-primary btn-sm ms-auto">edit assets</a>

                                </div>

                                <div class="row g-1">

                                    @foreach($pack->assets as $asset)
                                        <div class="col-2">
                                            <img class="img-fluid" src="{{$asset->url()}}" alt="{{$asset->name}}">
                                        </div>
                                    @endforeach

                                </div>


                                <hr>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>



@endsection


@section('scripts')


@endsection
