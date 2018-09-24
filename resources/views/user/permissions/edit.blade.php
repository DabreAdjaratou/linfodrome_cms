@extends('layouts.administrator.master')
@section('title', 'Edit a  permission')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Modifier une permission</h3>@endsection 


<form method="POST" action="{{ route('permissions.update',['accessLevel'=>$accessLevel]) }}">
	@csrf
	@method('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="accessLevel">{{('Niveau d\'accès:') }}</label>
		<input type=" text" name="accessLevel" value="{{ $accessLevel->title }}" disabled>
	</div>
<table class="uk-table uk-table-small uk-table-striped">
@foreach($resources as $resource)
<tr><td>
{{ $resource->title }}
</td>
@foreach($resource->getActions as $action)

{{ print_r($action) }}
{{-- @foreach ($permissions as $permission) 
@if($action->id==$permission->action_id && $resource->id==$permission->resource_id) 
@php $actions[]=$permission->action_id ;@endphp
<td> <label for="action"> {{ $action->title }} </label>
<input type="checkbox" name="{{ $resource->title}}[]" value="{{$action->id}}" class="uk-checkbox" checked></td>
@elseif($resource->id==$permission->resource_id && $action->id==$permission->action_id &&  !(in_array($action->id, $actions)))
<td>
	<label for="action"> {{ $action->title }} </label>
<input type="checkbox" name="{{ $resource->title}}[]" value="{{$action->id}}" class="uk-checkbox">
</td>
@endif
@endforeach --}} 

@endforeach

</tr>
@endforeach
</table>		
</form>

@endsection

