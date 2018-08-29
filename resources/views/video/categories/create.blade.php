@extends('layouts.administrator.master')
@section('title', 'Create a new category')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une category') }} </h3>@endsection 


<form method="POST" action="{{ route('video-categories.store') }}">
	@csrf
	<div>	
<label for="title">{{('Titre:')}}</label>
<input type="text" name="title" placeholder="Titre de la Categorie" required autofocus>

	</div>


<button type="submit">{{('Enregistrer')}}</button>
<button type="reset">{{('Annuler')}}</button>



</form>

@endsection