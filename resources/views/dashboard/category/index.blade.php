@extends('dashboard.layout')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('dashboard.category.index')}}">Categories</a></li>
@endsection

@section('content')


    {{--top--}}

    <div class="display-4 text-center mb-3">Categories</div>

    <div class="text-center mb-3">
        <a href="{{route('dashboard.category.create')}}" class="btn btn-success">Добавить</a>
    </div>

    {{--/top--}}


    <table class="table table-striped table-bordered">

        <tr class="head">
            <th>Название</th>
            <th>Действия</th>
        </tr>

        @foreach($categories as $category)

            <tr>

                <td>{{$category->name}}</td>

                <td>
                    <a href="{{route('dashboard.category.edit', $category)}}" class="btn btn-sm btn-primary">редактировать</a>
                    {!! Form::open(['route' => [ 'dashboard.category.destroy', $category->id], 'method' => 'delete', 'style' => 'display:inline-block'  ]) !!}
                    {!! Form::submit('удалить', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>

            </tr>
        @endforeach

    </table>

@endsection

@section('scripts')

@endsection
