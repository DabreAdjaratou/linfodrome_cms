@extends('layouts.administrator.master')
@section('title', 'Create a new ressource')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> Ajouter une ressource </h3>@endsection 


<form method="POST" action="{{ route('resources.store') }}">
	@csrf
	<div>
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset">{{('Annuler')}}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre de la ressource" value="{{ old('title') }}" required autofocus>

	</div>
	<div>	
		<label for="display_name">{{('Nom à affiché:')}}</label>
		<input type="text" name="display_name"  value="{{ old('display_name') }}" required>

	</div>
	<div>
		<label>{{('Tout selectionner') }}</label>
	 <input type="checkbox" name="checkAll" id="checkAll" class="uk-checkbox">
	</div>
	<div>	
	
			@foreach($actions as $action)
			<label>{{ ucfirst($action->title) }}</label>
			<input type="checkbox" name="actions[]" value="{{ $action->id }}" class="uk-checkbox" @if(is_array(old('actions')) && in_array($action->id, old('actions'))) checked @endif> 
				@endforeach 
	</div>

</form>

@endsection

@section('js')
<script type="text/javascript">
	$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
</script>
@endsection