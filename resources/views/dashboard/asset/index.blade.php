@extends('dashboard.layout')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('dashboard.asset.index')}}">Assets</a></li>
@endsection

@section('content')


    {{--top--}}

    <div class="display-4 text-center mb-3">Assets</div>

    <div class="text-center mb-3">
        <a href="{{route('dashboard.asset.create')}}" class="btn btn-success">Добавить</a>
    </div>

    {{--/top--}}


    <table class="table table-striped table-bordered">

        <tr class="head">
            <th>Название</th>
            <th>Действия</th>
        </tr>

        @foreach($assets as $asset)

            <tr>

                <td>{{$asset->name}}</td>

                <td>
                    <a href="{{route('dashboard.asset.edit', $asset)}}" class="btn btn-sm btn-primary">редактировать</a>
                    {!! Form::open(['route' => [ 'dashboard.asset.destroy', $asset->id], 'method' => 'delete', 'style' => 'display:inline-block'  ]) !!}
                    {!! Form::submit('удалить', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>

            </tr>
        @endforeach

    </table>

@endsection

@section('scripts')

@endsection
