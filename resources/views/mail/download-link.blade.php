@extends('mail.layout')


@section('content')

    <p style="font-size: 24px; font-weight: bold">Your Boykomarket download is ready</p>


    <p>
        Hello! You recently purchased '{{$item->name}}' {{$item->itemType()}} at boykomarket.com
    </p>

    <p>
        You can download this item as ZIP archive immediately:
    </p>

    <div style="text-align: center; padding: 32px 0">
        <a href="{{$item->downloadLink()}}" style="font-size: 20px; display: inline-block; background: #fff; padding: 8px 16px; border: 1px solid #00CCA2; border-radius: 64px; color:#00CCA2;text-decoration: none;">Download ZIP</a>
    </div>


    <p>
        Or use link: <br>

        <a href="{{$item->downloadLink()}}" style="color:#00CCA2;text-decoration: none;">{{$item->downloadLink()}}</a>
    </p>

    <p>
        Important note: you must be logged in your boykomarket.com account to download purchased items.
    </p>

    <p>
        Regards, <br>
        Boykomarket Team
    </p>

@endsection