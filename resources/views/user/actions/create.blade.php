@extends('layouts.administrator.master')
@section('title', 'Create a new action')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Ajouter une action </h3>@endsection 


<form method="POST" action="{{ route('actions.store') }}">
	@csrf
	<div>
		
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset">{{('Annuler')}}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre de l'action" required autofocus>

	</div>
	<div>	

		<label for="display_name">{{('Nom à afficher:')}}</label>
		<input type="text" name="display_name" placeholder="">

	</div>

</form>

@endsection
