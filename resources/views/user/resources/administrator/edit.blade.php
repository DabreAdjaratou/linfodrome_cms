@extends('layouts.administrator.master')
@section('title', 'Edit a ressource')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Modifier une ressource </h3>@endsection 


<form method="POST" action="{{ route('resources.update',['resource'=>$resource]) }}">
	@csrf
	@method('put')
<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre de la ressource" value="{{ $resource->title }}" required autofocus>
	</div>
		<div>	
		<label for="display_name">{{('Nom à affiché:')}}</label>
		<input type="text" name="display_name"  value="{{ $resource->display_name }}" required>

	</div>
	<div>
     <label>{{('Tout selectionner') }}</label>
	 <input type="checkbox" name="checkAll" id="checkAll" class="uk-checkbox">
	  </div>
	<div>	

		<label for="actions">{{('Actions:')}}</label>
		@foreach($allActions as $action)
		@foreach ($resource->getActions as $resourceAction)
		@if($resourceAction->id==$action->id)
		<label>{{ ucfirst($action->title) }}</label>
			<input type="checkbox" name="actions[]" value="{{ $action->id }}" class="uk-checkbox" checked> 	
		@endif
		@endforeach 
		@if(in_array($action->title,$arrayDiff))
		<label>{{ ucfirst($action->title) }}</label>
			<input type="checkbox" name="actions[]" value="{{ $action->id }}" class="uk-checkbox">
		@endif
		@endforeach 
		</div>
</form>
@endsection
@section('sidebar')
 @component('layouts.administrator.user-sidebar') @endcomponent 
@endsection
@section('js')
<script type="text/javascript">
	$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
</script>
@endsection