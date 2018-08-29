@extends('layouts.administrator.master')
@section('title', 'Create a new source')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une source ') }}</h3>@endsection 


<form method="POST" action="{{ route('article-sources.store') }}">
	@csrf
	<div>	
<label for="title">{{('Titre:')}}</label>
<input type="text" name="title" placeholder="Titre de la source" required autofocus>

	</div>


<button type="submit">{{('Enregistrer')}}</button>
<button type="reset">{{('Annuler')}}</button>



</form>

@endsection