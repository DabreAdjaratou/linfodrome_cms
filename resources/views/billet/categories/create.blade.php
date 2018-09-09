@extends('layouts.administrator.master')
@section('title', 'Create a new category')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une category') }} </h3>@endsection 


<form method="POST" action="{{ route('billet-categories.store') }}">
	@csrf
	<div>
		
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset">{{('Annuler')}}</button>
	</div>
<div>	
<label for="title">{{('Titre:')}}</label>
<input type="text" name="title" placeholder="Titre de la Categorie" required autofocus>
</div>
<div>	
		<label for="published">{{('Titre:')}}</label>
		<select name="published">
			<option value="{{ 0 }}">Non publié</option>
			<option value="{{ 1 }}">Publié</option>
		</select>
		
	</div>

</form>

@endsection