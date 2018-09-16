@extends('layouts.administrator.master')
@section('title', 'Edit a access level')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Modifier un niveau d'accès</h3>@endsection 


<form method="POST" action="{{ route('access-levels.update',['accessLevel'=>$accessLevel]) }}">
	@csrf
	@method('put')
<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre du niveau d'acces"  value="{{$accessLevel->title}}" required autofocus>
	</div>

	<div>
@foreach($allGroups as $group)
		@foreach ($group->getGroups as $accessLevelGroup)
		@if($accessLevelGroup->id==$group->id)
		<label>{{ ucfirst($group->title) }}</label>
			<input type="checkbox" name="groups[]" value="{{ $group->id }}" class="uk-checkbox" checked> 	
		@endif
		@endforeach 
		@if(in_array($group->title,$arrayDiff))
		<label>{{ ucfirst($group->title) }}</label>
			<input type="checkbox" name="groups[]" value="{{ $group->id }}" class="uk-checkbox">
		@endif
		@endforeach 




		{{-- @foreach($groups as $group)
		<ul>
			<input type="checkbox" name="groups[]" value="{{$group->id}}" class="uk-checkbox" @if(is_array(old('groups')) && in_array($group->id, old('groups'))) checked @endif>
			{{ ucfirst($group->title) }}
			@if(count($group->getChildren))
			@include('user.groups.groupChild',['children' => $group->getChildren,'view'=>$accessLevelView])
			@endif
		</ul>                                     
			@endforeach --}}
	</div>	
</form>
@endsection
