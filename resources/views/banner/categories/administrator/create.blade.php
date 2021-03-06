@extends('layouts.administrator.master')
@section('title', 'Create a new category')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une category') }} </h3>@endsection 


<form method="POST" action="{{ route('banner-categories.store') }}">
	@csrf
	<div>
		
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset" name="cancel" value="cancel" onclick="window.location.href='{{ route('banner-categories.index') }}'">{{('Annuler')}}</button>
		
	</div>
<div>	
<label for="title">{{('Titre:')}}</label>
<input type="text" name="title" placeholder="Titre de la Categorie" required autofocus>
</div>
	<div>	
		<label for="published">{{('Published:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}" @if(old('published')) checked @endif>
	</div>
</form>
@section('sidebar')
 @component('layouts.administrator.banner-sidebar') @endcomponent 
@endsection
@endsection