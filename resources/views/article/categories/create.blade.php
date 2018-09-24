@extends('layouts.administrator.master')
@section('title', 'Create a new category')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une category') }} </h3>@endsection 


<form method="POST" action="{{ route('article-categories.store') }}">
	@csrf

	<div>
		@can('trash', App\Models\Article\Category::class)
    <div>a le droit</div>
   <div>'na le droit</div>
@endcan

		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset">{{('Annuler')}}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre de la Categorie" value="{{ old('title') }}" required autofocus>

	</div>
	<div>	
		<label for="published">{{('Published:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}" @if(old('published')) checked @endif>
	</div>
</form>

@endsection