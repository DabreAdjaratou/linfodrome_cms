@extends('layouts.administrator.master')
@section('title', 'Create a new access level')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Ajouter un niveau d'accès</h3>@endsection 


<form method="POST" action="{{ route('access-levels.store') }}">
	@csrf
	<div>	
<label for="title">Titre:</label>
<input type="text" name="title" placeholder="Titre du niveau d'acces" required autofocus>
	</div>
<div>	
<button type="submit">Enregistrer</button>
<button type="reset">Annuler</button>
</div>



</form>

@endsection
