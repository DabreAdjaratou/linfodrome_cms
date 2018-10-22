@extends('layouts.administrator.master')
@section('title', 'put online a new video')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/tagify.css')}}" />
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Mettre en ligne une video ') }}</h3>@endsection 


<form method="POST" action="{{ route('videos.store') }}"  enctype="multipart/form-data" class="">
	@csrf
	<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
	<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset" name="cancel" value="cancel" onclick="window.location.href='{{ route('videos.index') }}'">{{('Annuler')}}</button>
		
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
		<input type="checkbox" name="published" value="{{ 1 }}" @if(old('published')) checked @endif>
	</div>
	<div>
		<label for="featured">{{('Featured:')}}</label>
		<input type="checkbox" name="featured" value="{{ 1 }}" @if(old('featured')) checked @endif>
	</div>
	<div>
		<label for="image">{{('Image:')}}</label>
		<input type="file" name="image" value="{{ old('image') }}" >
	</div>
	
	<div>
		<label for="video">{{('Video:')}}</label>
		<textarea name="video">{{{ old('video') }}}</textarea> 
	</div>
<div>
	<input name="tags" placeholder="write some tags" value="linfodrome.com,linfodrome.ci,linfodrome,abidjan,cote d'ivoire">
</div>
	<div>
	<label for="created_by">{{('Journaliste:')}}</label>
	    <select name="created_by">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" {{ (old("created_by") == $user->id ? "selected":"") }}>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>
<div>
	<label for="cameraman">{{('cameraman:')}}</label>

	    <select name="cameraman">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" {{ (old("cameraman") == $user->id ? "selected":"") }}>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>
	<div>
	<label for="editor">{{('editor:')}}</label>
	    <select name="editor">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" {{ (old("editor") == $user->id ? "selected":"") }}>{{ $user->name }} </option>
			@endforeach 
		</select>
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
@section('sidebar')
 @component('layouts.administrator.video-sidebar') @endcomponent 
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/jQuery.tagify.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/custom-tagify.js')}}" ></script>
@endsection
@endsection