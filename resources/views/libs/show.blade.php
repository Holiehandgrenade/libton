@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>{{ $lib->title }}</h3>
            <p>{{ $lib->body }}</p>


            @can('update', $lib)
                <a href="/libs/{{ $lib->id }}/edit">Edit Lib</a>
            @endcan

            @can('destroy', $lib)
                {!! Form::model($lib, ['url' => ['libs', $lib->id], 'method' => 'delete' ]) !!}
                    {!! Form::submit('Delete Lib') !!}
                {!! Form::close() !!}
            @endcan
        </div>

        <a href="/libs/{{ $lib->id }}/play">Play this lib!</a>
    </div>
@endsection