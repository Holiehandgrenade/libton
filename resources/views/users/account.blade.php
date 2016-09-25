@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {!! Form::model($user, ['url' => ['/users', $user->id], 'method' => 'patch']) !!}
            <div class="form-group">
                {!! Form::label('first_name', 'First Name') !!}
                {!! Form::text('first_name', $user->first_name, [
                    'class' => 'form-control',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('last_name', 'Last Name') !!}
                {!! Form::text('last_name', $user->last_name, [
                    'class' => 'form-control',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', $user->email, [
                    'class' => 'form-control',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', 'New Password') !!}
                {!! Form::password('password', [
                    'class' => 'form-control',
                ]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('confirm_password', 'Confirm Password') !!}
                {!! Form::password('confirm_password', [
                    'class' => 'form-control',
                ]) !!}
            </div>
            {!! Form::submit('Save Changes', [
                'class' => 'btn btn-default btn-lg',
            ]) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection