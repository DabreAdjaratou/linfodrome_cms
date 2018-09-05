@extends('layouts.administrator.master')
@section('title', 'put online a new video')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Mettre en ligne une video ') }}</h3>@endsection 


<form method="POST" action="{{ route('videos.store') }}"  enctype="multipart/form-data" class="">
	@csrf
	<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
	<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
	<button type="reset">{{('Annuler')}}</button>
	
	<div>
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre"  value="{{ old('title') }}" required autofocus>
	</div>
	<label for="category">{{('category:')}}</label>
	<select  name="category" >
		<option> </option>
		@foreach($categories as $category)
		<option value="{{ $category->id }}" {{ (old("category") == $category->id ? "selected":"") }}>{{ucfirst($category->title) }}</option>
		@endforeach
	</select>
	<div>
		<label for="published">{{('Published:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}">
	</div>
	<div>
		<label for="featured">{{('Featured:')}}</label>
		<input type="checkbox" name="featured" value="{{ 1 }}">
	</div>
	<div>
		<label for="image">{{('Image:')}}</label>
		<input type="file" name="image" value="{{ old('image') }}" >
	</div>
	
	<div>
		<label for="video">{{('Video:')}}</label>
		<textarea name="video" value="{{ old('video') }}">{{{ old('video') }}}</textarea> 
	</div>

	<div>
	<label for="created_by">{{('Journaliste:')}}</label>
{{-- 	<span>{{ Auth::User()->name}}</span>
        <input type="hidden" name="auth_userid" value="{{ Auth::id() }}"> --}}
	    <select name="created_by">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" {{ (old("created_by") == $user->id ? "selected":"") }}>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>
<div>
		<label for="cameraman">{{('Cameraman:')}}</label>
		<input type="text" name="cameraman" value="{{ old('cameraman') }}" >
	</div>
	<div>
		<label for="editor">{{('Monteur:')}}</label>
		<input type="text" name="editor" value="{{ old('editor') }}" >
	</div>
	<div>
		<label for="start_publication_at">{{('Star publication at:')}}</label>
		<input type="text" name="start_publication_at" value="{{ old('start_publication_at') }}" >
	</div>
	<div>
		<label for="stop_publication_at">{{('Stop publication at:')}}</label>
		<input type="text" name="stop_publication_at"  value="{{ old('stop_publication_at') }}">
	</div>

</form>
@section('js')

@endsection
@endsection