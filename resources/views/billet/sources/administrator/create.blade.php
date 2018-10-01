@extends('layouts.administrator.master')
@section('title', 'Create a new source')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une source ') }}</h3>@endsection 


<form method="POST" action="{{ route('billet-sources.store') }}">
	@csrf

	<div>
		<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
		<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset" name="cancel" value="cancel" onclick="window.location.href='{{ route('billet-categories.index') }}'">{{('Annuler')}}</button>
		
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre de la source" value="{{ old('title') }}" required autofocus>
	</div>
<div>	
		<label for="published">{{('Published:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}" @if(old('published')) checked @endif class="uk-checkbox">
	</div>
</form>
</form>

@endsection
@section('sidebar')
 @component('layouts.administrator.billet-sidebar') @endcomponent 
@endsection