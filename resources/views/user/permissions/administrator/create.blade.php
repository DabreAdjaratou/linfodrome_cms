@extends('layouts.administrator.master')
@section('title', 'Create a new permission')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Ajouter un permission</h3>@endsection 


<form method="POST" action="{{ route('permissions.store') }}">
	@csrf
	<div>
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset" name="cancel" value="cancel" onclick="window.location.href='{{ route('permissions.index') }}'">{{('Annuler')}}</button>
		
	</div>
	<div>	
		<label for="accessLevel">{{('Niveau d\'accès:') }}</label>
		<select name="accessLevel">
			<option value=""> </option>
			@foreach ($accessLevels as $accessLevel)
			<option value="{{ $accessLevel->id }}" @if(old('accessLevel')==$accessLevel->id) selected @endif> {{ $accessLevel->title }}</option>
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
	<label for="actions"> {{ $action->title }} </label>
<input type="checkbox" name="{{ $resource->title}}[]" value="{{$action->id}}" class="uk-checkbox">

</td>
@endforeach
</tr>
@endforeach
</table>		
</form>

@endsection

