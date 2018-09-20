@extends('layouts.administrator.master')
@section('title', 'Edit a banner')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Modifier une bannière ') }}</h3>@endsection 


<form method="POST" action="{{ route('banners.update',['banner'=>$banner]) }}"  enctype="multipart/form-data" class="">
	@csrf
	@method('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre"  value="{{ $banner->title }}" required autofocus>
	</div>
	<div>
		<label for="type">{{('Type:')}}</label>
		<select name="type">
			<option></option>
			<option value="{{ 0 }}" {{ $banner->type == 0 ? "selected":"" }}>{{ ('Image') }}</option>
			<option value="{{ 1 }}" {{ $banner->type == 1 ? "selected":"" }}>{{ ('Personnalisé') }}</option>
		</select>
	</div>
	<div>
	<label for="category">{{('category:')}}</label>
	<select  name="category" >
		<option> </option>
		@foreach($categories as $category)
		<option value="{{ $category->id }}" {{ $banner->category_id == $category->id ? "selected":"" }}>{{ucfirst($category->title) }}</option>
		@endforeach
	</select>
	</div>
	<div>
		<label for="published">{{('Published:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}" @if($banner->published==1) checked @endif>
	</div>
	<div>
		<label for="url">{{('URL:')}}</label>
		<input type="text" name="url" placeholder="URL"  value="{{ $banner->url}}" required autofocus>
	</div>
	
	<div>
	<label for="created_by">{{('Auteur:')}}</label>
	<span>{{ Auth::User()->name}}</span>
        <input type="hidden" name="auth_userid" value="{{ Auth::id() }}">
		<select name="created_by">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" {{ $banner->created_by == $user->id ? "selected":"" }}>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>

	<div>
		<label for="start_publication_at">{{('Star publication at:')}}</label>
		<input type="text" name="start_publication_at" value="{{ $banner->start_publication_at }}" >
	</div>
	<div>
		<label for="stop_publication_at">{{('Stop publication at:')}}</label>
		<input type="text" name="stop_publication_at"  value="{{ $banner->stop_publication_at}}">
	</div>
<div class="uk-grid">
	<div class="uk-width-1-3">
		<fieldset>
	
	<legend>Ordinateur</legend>

	<div>
		<label for="imageForComputer">{{('Image:')}}</label>
		<input type="file" name="imageForComputer" value="" >
	</div>
	<div>
		<label for="sizeForComputer">{{('Size:')}}</label>
		<input type="text" name="sizeForComputer" placeholder="Size"  value="{{  json_decode($banner->size)->computer}} " required autofocus>
	</div>
	<div>
		<label for="codeForComputer">{{('Code:')}}</label>
		<textarea name="codeForComputer" >{{ json_decode($banner->code)->computer}}</textarea> 
	</div>
</fieldset>
	</div>
	<div class="uk-width-1-3">
		<fieldset>
	
	<legend>tablette</legend>
	<div>
		<label for="imageForTablet">{{('Image:')}}</label>
		<input type="file" name="imageForTablet" value="" >
	</div>
	<div>
		<label for="sizeForTablet">{{('Size:')}}</label>
		<input type="text" name="sizeForTablet" placeholder="Size"  value="{{ json_decode($banner->size)->tablet}}" required autofocus>
	</div>
	<div>
		<label for="codeForTablet">{{('Code:')}}</label>
		<textarea name="codeForTablet" >{{ json_decode($banner->code)->tablet}}</textarea> 
	</div>
</fieldset>
	</div>

	<div class="uk-width-1-3">
		<fieldset>
	
	<legend>Modile</legend>
	<div>
		<label for="imageForMobile">{{('Image:')}}</label>
		<input type="file" name="imageForMobile" value="" >
	</div>
	<div>
		<label for="sizeForMobile">{{('Size:')}}</label>
		<input type="text" name="sizeForMobile" placeholder="Size"  value="{{ json_decode($banner->size)->mobile}}" required autofocus>
	</div>
	<div>
		<label for="codeForMobile">{{('Code:')}}</label>
		<textarea name="codeForMobile" >{{ json_decode($banner->code)->mobile}}</textarea> 
	</div>
</fieldset>
	</div>
</div>




</form>
@section('js')

@endsection
@endsection