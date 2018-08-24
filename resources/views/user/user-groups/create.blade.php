@extends('layouts.administrator.master')
@section('title', 'Create a new group')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Ajouter un groupe</h3>@endsection 


<form method="POST" action="{{ route('user-groups.store') }}">
	@csrf

	<div>	
<label for="title">{{('Titre:') }}</label>
<input type="text" name="title" placeholder="Titre du groupe" required autofocus>
	</div>

	<div>	
<label for="parent">Groupe parent</label>
<select name="parent">
<option value="0"> </option>
	@foreach ($parents as $parent)
<option value="{{ $parent->id }}"> {{ $parent->title }}</option>
	@endforeach 

</select>
	</div>

<button type="submit">Enregistrer</button>
<button type="reset">Annuler</button>


</form>

@endsection
