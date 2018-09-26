@extends('layouts.administrator.master')
@section('title', 'Edit a group')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Modifier un groupe</h3>@endsection 


<form method="POST" action="{{ route('user-groups.update',['group'=>$group]) }}">
	@csrf
	@method('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:') }}</label>
		<input type="text" name="title" placeholder="Titre du groupe" value="{{ $group->title }}" required autofocus>
	</div>

	<div>	
		<label for="parent">{{('Groupe parent:') }}</label>
		<select name="parent">
			<option value="0"> </option>
			@foreach ($parents as $parent)
			<option value="{{ $parent->id }}" @if($group->parent_id==$parent->id) selected @endif> {{ $parent->title }}</option>
			@endforeach 

		</select>
	</div>
	
</form>

@endsection
