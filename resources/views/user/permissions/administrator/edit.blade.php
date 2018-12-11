@extends('layouts.administrator.master')
@section('title', 'Edit a  permission')
@section('css')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
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
		<tr>
			<td>
				{{ $resource->title }}
			</td>
				
				

				@foreach($resource->getActions as $action)
				<td>
				<label for="action" id="{{ $resource->id.'-'.$action->id }}"> {{ $action->title }} </label>
				@foreach($permissions as $permission)
				@if($permission->resource_id==$resource->id && $action->id == $permission->action_id)
				<input type="checkbox" name="{{ $resource->title}}[]" value="{{$action->id}}" class="uk-checkbox" checked>
				<script type="">
					var id='<?php echo "#".$resource->id."-".$action->id ; ?>';
					// console.log($(id)[0].nextElementSibling);
					if($(id)[0].nextElementSibling){

					console.log('ddd');
					}else{
					console.log('ff');

					}
				</script>
				@endif
				@endforeach
					<input type="checkbox" name="{{ $resource->title}}[]" value="{{$action->id}}" class="uk-checkbox">
				
				

			@endforeach 
			</td>

		</tr>
		@endforeach
	</table>		
</form>

@endsection
@section('sidebar')
 @component('layouts.administrator.user-sidebar') @endcomponent 
@endsection

