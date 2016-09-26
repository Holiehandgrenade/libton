@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($libs as $lib)
            <div class="row">
                <a class="lib-links" id="view-lib-{{ $lib->id }}" href="/libs/{{ $lib->id }}">{{ $lib->title }}</a>
            </div>
        @endforeach
    </div>
@endsection