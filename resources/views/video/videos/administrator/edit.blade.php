@extends('layouts.administrator.master')
@section('title', 'Edit a video')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{asset('css/tagify.css')}}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">

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
		<textarea name="video" >{{ $video->code }}</textarea> 
	</div>
<div>
		@if($video->keywords)
	<input name="tags" placeholder="Mots clés" value="{{ $video->keywords }}">
	@else
		<input name="tags" placeholder="Mots clés" value="linfodrome.com,linfodrome.ci,linfodrome,abidjan,cote d'ivoire">
	@endif
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
	<label for="editor">{{('Monteur:')}}</label>
	    <select name="editor">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" @if($video->editor == $user->id)  selected @endif }}>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>
	<div>
		<label for="start_publication_at">{{('Star publication at:')}}</label>
		<input type="text" name="start_publication_at" class="datepicker"  @if(isset($video->start_publication_at)) value='{{ date("d-m-Y H:i:s", strtotime($video->start_publication_at))}}' @endif autocomplete="off"  >
	</div>
	<div>
		<label for="stop_publication_at">{{('Stop publication at:')}}</label>
		<input type="text" name="stop_publication_at"  class="datepicker"  @if(isset($video->stop_publication_at)) value='{{ date("d-m-Y H:i:s", strtotime($video->stop_publication_at))}}' @endif autocomplete="off" >
	</div>

</form>
@section('sidebar')
 @component('layouts.administrator.video-sidebar') @endcomponent 
@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/jQuery.tagify.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/custom-tagify.js')}}" ></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/custom-datepicker.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>
<script type="text/javascript" src="{{ asset('js/custom-jodit.js') }}"></script>
@endsection
@endsection