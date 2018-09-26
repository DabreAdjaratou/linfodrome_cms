@extends('layouts.administrator.master')
@section('title', 'Edit a new action')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Modifier une action </h3>@endsection 


<form method="POST" action="{{ route('actions.update',['action'=>$action]) }}">
	@csrf
	@method('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre de l'action" value="{{$action->title}}" required autofocus>

	</div>
	<div>	

		<label for="display_name">{{('Nom à afficher:')}}</label>
		<input type="text" name="display_name" value="{{$action->display_name }}">

	</div>

</form>

@endsection
