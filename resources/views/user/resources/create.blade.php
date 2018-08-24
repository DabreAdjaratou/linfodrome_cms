@extends('layouts.administrator.master')
@section('title', 'Creat a new ressources')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Ajouter une ressource </h3>@endsection 


<form method="POST" action="{{ route('resources.store') }}">
	@csrf
	<div>	
<label for="title">Titre:</label>
<input type="text" name="title" placeholder="Titre de la ressource" required autofocus>

	</div>
<div>	

<label for="actions">Actions:</label>
<select name="actions[]" multiple required> 
@foreach($actions as $action)
<option value="{{ $action->id }}">{{ $action->title }}</option>
@endforeach 

</select>

</div>

<button type="submit">Enregistrer</button>
<button type="reset">Annuler</button>



</form>

@endsection
