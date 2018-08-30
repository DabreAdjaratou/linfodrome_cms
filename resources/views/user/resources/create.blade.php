@extends('layouts.administrator.master')
@section('title', 'Create a new ressource')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Ajouter une ressource </h3>@endsection 


<form method="POST" action="{{ route('resources.store') }}">
	@csrf
	<div>
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset">{{('Annuler')}}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre de la ressource" required autofocus>

	</div>
	<div>	

		<label for="actions">{{('Actions:')}}</label>
		<select name="actions[]" multiple required > 
			@foreach($actions as $action)
			<option value="{{ $action->id }}">{{ $action->title }}</option>
			@endforeach 

		</select>

	</div>

</form>

@endsection
