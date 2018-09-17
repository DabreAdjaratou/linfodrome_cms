@extends('layouts.administrator.master')
@section('title', 'Edit a video')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Modifier une video ') }}</h3>@endsection 


<form method="POST" action="{{ route('videos.update',['video'=>$video]) }}"  enctype="multipart/form-data" class="">
	@csrf
	@method ('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	
	<div>
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre"  value="{{$video->title }}" required autofocus>
	</div>
	<label for="category">{{('category:')}}</label>
	<select  name="category" >
		<option> </option>
		@foreach($categories as $category)
		<option value="{{ $category->id }}" @if($video->category_id == $category->id)  selected @endif>{{ucfirst($category->title) }}</option>
		@endforeach
	</select>
	<div>
		<label for="published">{{('Published:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}" @if($video->published == 1)  checked @endif >
	</div>
	<div>
		<label for="featured">{{('Featured:')}}</label>
		<input type="checkbox" name="featured" value="{{ 1 }}" @if($video->featured == 1)  checked="" @endif>
	</div>
	<div>
		<label for="image">{{('Image:')}}</label>
		<input type="file" name="image" value="{{ $video->image}}" >
	</div>
	
	<div>
		<label for="video">{{('Video:')}}</label>
		<textarea name="video" value="{{ $video->code }}">{{{ old('video') }}}</textarea> 
	</div>

	<div>
	<label for="created_by">{{('Journaliste:')}}</label>
	    <select name="created_by">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" @if($video->created_by == $user->id)  selected @endif>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>
<div>
	<label for="cameraman">{{('cameraman:')}}</label>

	    <select name="cameraman">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" @if($video->cameraman == $user->id)  selected @endif>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>
	<div>
	<label for="editor">{{('editor:')}}</label>
	    <select name="editor">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" @if($video->editor == $user->id)  selected @endif }}>{{ $user->name }} </option>
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
@section('js')

@endsection
@endsection