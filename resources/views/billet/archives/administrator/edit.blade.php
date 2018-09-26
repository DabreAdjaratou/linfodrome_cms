@extends('layouts.administrator.master')
@section('title', 'Edit an billet')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Modifier une billet ') }}</h3>@endsection 


<form method="POST" action="{{ route('billet-archives.update',['billet'=>$archive] )}}"  enctype="multipart/form-data" class="">
	@csrf
	@method('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="ontitle">{{('Sur Titre:')}}</label>
		<input type="text" name="ontitle" placeholder="Sur titre" value="{{ $archive->ontitle }}">
	</div>
	<div>
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre"  value="{{ $archive->title }}" required autofocus>
	</div>
	<label for="category">{{('category:')}}</label>
	<select  name="category" >
		<option> </option>
		@foreach($categories as $category)
		<option value="{{ $category->id }}" @if($archive->category_id == $category->id)  selected @endif>{{ucfirst($category->title) }}</option>
		@endforeach
	</select>
	<div>
		<label for="published">{{('Published:')}}</label>
		<input type="checkbox" name="published" value="{{1}}" @if($archive->published==1) checked @endif class="uk-checkbox"  >
	</div>
	<div>
		<label for="featured">{{('Featured:')}}</label>
		<input type="checkbox" name="featured" value="{{1}}"" @if($archive->featured==1) checked @endif class="uk-checkbox"">
	</div>
	<div>
		<label for="image">{{('Image:')}}</label>
		<input type="file" name="image" value="{{ $archive->image}}" >
	</div>
	<div>
		<label for="image_legend">{{('Image caption:')}}</label>
		<input type="text" name="image_legend"  value="{{ $archive->image_legend}}">
	</div>

	<div>
		<label for="introtext">{{('Intro text:')}}</label>
		<input type="text" name="introtext" value="{{ $archive->introtext }}" >
	</div>

	<div>
		<label for="fulltext">{{('Content:')}}</label>
		<textarea name="fulltext" id="fulltext" >{{ $archive->fulltext }}</textarea>
	</div>
	<div>
		<label for="source">{{('Source:')}}</label>
		<select  name="source" >
			<option> </option>
			@foreach($sources as $source)
		    <option value="{{ $source->id }}" @if($archive->source_id == $source->id)  selected @endif>{{ucfirst($source->title) }}</option>
			@endforeach
		</select>
	</div>

	<div>
	<label for="created_by">{{('Auteur:')}}</label>
	<span>{{ Auth::User()->name}}</span>
        <input type="hidden" name="auth_userid" value="{{ Auth::id() }}">
		<select name="created_by">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" @if($archive->created_by == $user->id)  selected @endif>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>

	<div>
		<label for="start_publication_at">{{('Star publication at:')}}</label>
		<input type="text" name="start_publication_at" value="{{ $archive->start_publication_at }}" >
	</div>
	<div>
		<label for="stop_publication_at">{{('Stop publication at:')}}</label>
		<input type="text" name="stop_publication_at"  value="{{ $archive->stop_publication_at }}">
	</div>

</form>
@section('js')

@endsection
@endsection