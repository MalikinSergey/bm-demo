@extends('dashboard.layout')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{route('dashboard.family.index')}}">Families</a>
    </li>
@endsection

@section('content')


    {{--top--}}

    <div class="h2 mb-3">Families

        @if( request()->input('type') )

                         ({{request()->input('type')}}s)
        @else
        @endif
    </div>

    <div class="mb-3">
        <a href="{{route('dashboard.family.create')}}" class="btn btn-success">Add new</a>
    </div>

    {{--/top--}}


    <table class="table table-striped table-bordered">

        <tr class="head">
            <th>Name</th>
            <th>Status</th>
            <th>Assets</th>
            <th>Packs</th>
            <th>Uploads</th>
            <th>Actions</th>
        </tr>

        @foreach($families as $family)

            <tr>

                <td>

                    <div>
                        {{$family->name}}
                    </div>

                    @if($family->hasCover())
                        <div>

                            <img src="{{$family->getCoverUrl()}}" alt="" style="width: 200px;" class="img-fluid img-thumbnail mb-4">
                        </div>
                    @endif

                </td>
                <td>{{$family->status}}</td>
                <td>
                    <a href="{{route('dashboard.asset.edit_multiple', ['family_id' => $family->id])}}">{{$family->assets()->count()}} assets</a>
                </td>

                <td>
                    <a href="{{route('dashboard.pack.index', ['family_id' => $family->id])}}">{{$family->packs()->count()}} packs</a>
                </td>

                <td>

                    @foreach($family->uploads()->take(3)->get() as $upload)
                        <div>
                            <a href="{{route('dashboard.asset.edit_multiple', ['upload_id' => $upload->id])}}">
                                {{$upload->assets()->count()}} assets at {{$upload->created_at->format('Y-m-d H:i')}}
                            </a>
                        </div>
                    @endforeach

                    @if($family->uploads()->count() > 3)

                        ...
                        <a href="{{route('dashboard.family.show', $family->id)}}">all uploads</a>

                    @endif

                </td>

                <td>
                    <a href="{{route('website.family.show', $family->slug)}}" target="_blank" class="btn btn-sm btn-success">open</a>
                    {{--                    <a href="{{route('dashboard.family.show', $family)}}" class="btn btn-sm btn-primary">details</a>--}}
                    <a href="{{route('dashboard.asset.add_multiple', $family)}}" class="btn btn-sm btn-primary">upload assets</a>
                    <a href="{{route('dashboard.family.edit', $family)}}" class="btn btn-sm btn-primary">edit family info</a>
                    {!! Form::open(['route' => [ 'dashboard.family.destroy', $family->id], 'method' => 'delete', 'style' => 'display:inline-block'  ]) !!}
                    {!! Form::submit('destroy family', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>

            </tr>
        @endforeach

    </table>

@endsection

@section('scripts')

@endsection
