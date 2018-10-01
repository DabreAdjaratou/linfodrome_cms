@extends('layouts.administrator.master')
@section('title', 'Create a new access level')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Ajouter un niveau d'accès</h3>@endsection 


<form method="POST" action="{{ route('access-levels.store') }}">
	@csrf
	<div>
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset" name="cancel" value="cancel" onclick="window.location.href='{{ route('access-level.index') }}'">{{('Annuler')}}</button>
		
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre du niveau d'acces"  value="{{ old('title') }}" required autofocus>
	</div>

	<div>
		@foreach($groups as $group)
		<ul>
			<input type="checkbox" name="groups[]" value="{{$group->id}}" class="uk-checkbox" @if(is_array(old('groups')) && in_array($group->id, old('groups'))) checked @endif>
			{{ ucfirst($group->title) }}
			@if(count($group->getChildren))
			@include('user.groups.administrator.groupChild',['children' => $group->getChildren,'view'=>'view'])
			@endif
		</ul>                                     
			@endforeach
	</div>	
</form>
@endsection
@section('sidebar')
 @component('layouts.administrator.user-sidebar') @endcomponent 
@endsection
