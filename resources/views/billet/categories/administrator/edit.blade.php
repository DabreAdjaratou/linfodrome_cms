@extends('layouts.administrator.master')
@section('title', 'Edit a category')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Modifier une category') }} </h3>@endsection 


<form method="POST" action="{{ route('billet-categories.update',['category'=>$category]) }}">
	@csrf
	@method('put')
   	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" value="{{ $category->title }}" required autofocus>

	</div>
	<div>	
		<label for="published">{{('Publié:')}}</label>
		<input type="checkbox" name="published" value="{{1}}" @if($category->published==1) checked @endif class="uk-checkbox">
	</div>
</form>

@endsection
@section('sidebar')
 @component('layouts.administrator.billet-sidebar') @endcomponent 
@endsection