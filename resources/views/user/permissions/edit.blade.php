@extends('layouts.administrator.master')
@section('title', 'Edit a  permission')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Modifier une permission</h3>@endsection 


<form method="POST" action="{{ route('permissions.update',['permission'=$permission]) }}">
	@csrf
	<div>
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset">{{('Annuler')}}</button>
	</div>
	<div>	
		<label for="accessLevel">{{('Niveau d\'accès:') }}</label>
		<select name="accessLevel">
			<option value="0"> </option>
			@foreach ($accessLevels as $accessLevel)
			<option value="{{ $accessLevel->id }}"> {{ $accessLevel->title }}</option>
			@endforeach 
		</select>
	</div>
<table class="uk-table uk-table-small uk-table-striped">
@foreach($resources as $resource)
<tr><td>
{{ $resource->title }}
</td>
@foreach($resource->getActions as $action)
<td>
	<label for="action"> {{ $action->title }} </label>
<input type="checkbox" name="{{ $resource->title}}[]" value="{{$action->id}}" class="uk-checkbox">
</td>
@endforeach
</tr>
@endforeach
</table>		
</form>

@endsection

