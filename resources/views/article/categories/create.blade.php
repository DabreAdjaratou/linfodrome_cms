@extends('layouts.administrator.master')
@section('title', 'Create a new category')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une category') }} </h3>@endsection 


<form method="POST" action="{{ route('article-categories.store') }}">
	@csrf

	<div>
		@can('create', App\Models\Article\Category::class)
    <div>a le droit</div>
   <div>'na le droit</div>
@endcan

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