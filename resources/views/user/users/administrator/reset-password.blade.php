@extends('layouts.administrator.master')
@section('title', 'Edit a user')
@section('css')
@endsection

@section('content')

<div>
    <form method="POST" action="{{ route('users.update-password',['user'=>$user]) }}" enctype="multipart/form-data" class="">
        @csrf
        @method ('put')
        <div>
            <button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
            <button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
        </div>                         <div>
            <label for="password">{{('Mot de passe') }}</label>
            <input id="password" type="password" name="password" value="" >
        </div>

        <div>
            <label for="password-confirm">{{('Confirmer le mot de passe') }}</label>
            <input id="password-confirm" type="password"  name="password_confirmation" value="" >
        </div>
        
    </form>
</div>

@endsection
@section('sidebar')
@component('layouts.administrator.user-sidebar') @endcomponent 
@endsection
