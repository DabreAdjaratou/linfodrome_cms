@extends('layouts.administrator.master')
@section('title', 'Edit a source')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Modifier une source ') }}</h3>@endsection 


<form method="POST" action="{{ route('article-sources.update',['source'=>$source]) }}">
	@csrf
@method('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre de la source" value="{{ $source->title }}" required autofocus>
	</div>
<div>	
		<label for="published">{{('Published:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}" @if($source->published==1) checked @endif class="uk-checkbox">
	</div>
</form>
</form>

@endsection
@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@endsection