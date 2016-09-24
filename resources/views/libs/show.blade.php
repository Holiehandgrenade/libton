@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <a href="/libs/{{ $lib->id }}/play" class="btn btn-default">Play this lib!</a>
            </div>


            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $lib->title }}</h3>
                    </div>
                    <div class="panel-body">
                        {!! $lib->body !!}
                    </div>
                </div>

            </div>

            <div class="col-md-2">
                @can('update', $lib)
                    <a href="/libs/{{ $lib->id }}/edit" class="btn btn-default">Edit Lib</a>
                @endcan


                @can('destroy', $lib)
                    {!! Form::model($lib, ['url' => ['libs', $lib->id], 'method' => 'delete' ]) !!}
                        {!! Form::submit('Delete Lib', ['class' => 'btn btn-default']) !!}
                    {!! Form::close() !!}
                @endcan
            </div>
        </div>

    </div>
@endsection