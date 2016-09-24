@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($libs as $lib)
            <div class="row">
                <div class="lib">
                    <a id="view-lib-{{ $lib->id }}" href="/libs/{{ $lib->id }}">View Lib</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection