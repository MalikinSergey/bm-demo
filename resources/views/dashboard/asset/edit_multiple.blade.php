@extends('dashboard.layout')

@section('breadcrumbs')

    <li class="breadcrumb-item">
        <a href="{{route('dashboard.family.index')}}">Families</a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{route('dashboard.family.show', $family->id)}}">{{$family->name}}</a>
    </li>

    <li class="breadcrumb-item active">

        @if($upload)
            Assets  uploaded at {{$upload->created_at->format('Y-m-d H:i:s')}}
        @endif

        @if($pack)
            {{$pack->name}} assets
        @endif

        @if($family)
            {{$family->name}} assets
        @endif

    </li>


@endsection

@section('content')


    <div class="h2">
        @if($source === 'upload')
            {{$upload->assets->count() }} assets  uploaded in  "{{$family->name}}" family at {{$upload->created_at->format('Y-m-d H:i:s')}}
        @endif

        @if($source === 'pack')
            "{{$pack->name}}" pack assets
        @endif

        @if($source === 'family')
            "{{$family->name}}" family assets
        @endif
    </div>

    <hr>

    <div class="row">

        <div class="col-4">
            {{Form::open(['route' => [ 'dashboard.asset.edit_multiple' ], 'method' => 'GET' ])}}

            {{Form::hidden('family_id', $family->id)}}

            <input type="text" value="{{request()->input('name')}}" name="name" class="form-control mb-2" placeholder="icon name">

            <button class="btn btn-primary">Search</button>

            {{Form::close()}}
        </div>

    </div>


    {{Form::open(['route' => [ 'dashboard.asset.update_multiple' ], 'method' => 'POST' ])}}

    @foreach($assets as $id => $asset)

        <div class="row align-items-center">

            <div class="col-1">
                <div class="form-check form-check-inline">
                    {{Form::checkbox("selected_assets[]", $asset->id, null, ['class' => 'form-check-input', 'id' => 'sa_'.$asset->id] )}}</div>
                <img src="{{$asset->url()}}" alt="" class="img-fluid">
            </div>

            <div class="col-2">
                <div class="form-floating mb-3">
                    <input name="asset[{{$asset->id}}][name]" type="text" class="form-control" id="asset_n_{{$asset->id}}" placeholder="" value="{{$asset->name}}">
                    <label for="asset_n_{{$asset->id}}">Name</label>
                </div>
            </div>

            <div class="col-3">
                <div class="form-floating mb-3">
                    <input name="asset[{{$asset->id}}][tag_words]" type="text" class="form-control" id="asset_t_{{$asset->id}}" placeholder="" value="{{$asset->tags->pluck('name')->join(', ')}}">
                    <label for="asset_t_{{$asset->id}}">Tags, comma separated</label>
                </div>
            </div>



            <div class="col-1">
                <div class="form-floating mb-3">
                    <input name="asset[{{$asset->id}}][position]" type="text" class="form-control" id="asset_n_{{$asset->id}}" placeholder="" value="{{$asset->position}}">
                    <label for="asset_n_{{$asset->id}}">Position</label>
                </div>
            </div>


            <div class="col-5">

                <div class="row">

                    <div class="col">

                        @foreach($family->packs as $pack)

                            <div class="form-check form-check-inline">
                                {{Form::checkbox("asset[{$asset->id}][packs][]", $pack->id, $asset->packs->contains($pack), ['class' => 'form-check-input', 'id' => 'pa_'.$asset->id.$pack->id] )}}
                                <label class="form-check-label" for="{{'pa_'.$asset->id.$pack->id}}">{{$pack->name}}</label>
                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        <hr>

    @endforeach


    <div class="d-flex justify-content-center">
        {!! $assets->links() !!}
    </div>



    <button class="btn btn-primary">Save</button>

    <button class="btn btn-danger" name="delete_assets" value="1">Delete selected assets</button>

    {{Form::close()}}



@endsection


@section('scripts')


@endsection
