@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {!! Form::model($lib, ['url' => ['/libs', $lib->id], 'method' => 'patch']) !!}
            <div class="form-group">
                {!! Form::label('title', 'Title') !!}
                {!! Form::text('title', null, [
                    'class' => 'form-control',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('body', 'Body') !!}
                {!! Form::textarea('body', null, [
                    'class' => 'form-control',
                ]) !!}
            </div>
                {!! Form::submit('Update Lib', [
                    'class' => 'btn btn-primary btn-lg',
                ]) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection