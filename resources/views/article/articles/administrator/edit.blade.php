@extends('layouts.administrator.master')
@section('title', 'Edit an article')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{asset('css/tagify.css')}}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Modifier une article ') }}</h3>@endsection 
<div class="uk-grid">
	<div class="uk-width-2-3">
<form method="POST" action="{{ route('articles.update',['article'=>$article] )}}"  enctype="multipart/form-data" class="">
	@csrf
	@method('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>	
		<label for="ontitle">{{('Sur Titre:')}}</label>
		<input type="text" name="ontitle" placeholder="Sur titre" value="{!! $article->ontitle !!}">
	</div>
	<div>
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" id="title" placeholder="Titre"  value="{{ $article->title }}" required autofocus>
	</div>
	<label for="category">{{('category:')}}</label>
	<select  name="category" >
		<option> </option>
		@foreach($categories as $category)
		<option value="{{ $category->id }}" @if($article->category_id == $category->id)  selected @endif>{{ucfirst($category->title) }}</option>
		@endforeach
	</select>
	<div>
		<label for="published">{{('Publié:')}}</label>
		<input type="checkbox" name="published" value="{{1}}" @if($article->published==1) checked @endif class="uk-checkbox"" >
	</div>
	<div>
		<label for="featured">{{('En vedette:')}}</label>
		<input type="checkbox" name="featured" value="{{1}}"" @if($article->featured==1) checked @endif class="uk-checkbox"">
	</div>
	<div>
		<label for="image">{{('Image:')}}</label>
		<input type="file" name="image" value="{{ $article->image}}" >
	</div>
	<div>
		<label for="image_legend">{{('Legende:')}}</label>
		<input type="text" name="image_legend"  value="{{ $article->image_legend}}">
	</div>

	<div>
		<label for="video">{{('Video:')}}</label>
		<input type="text" name="video" value="{{$article->video}}" >
	</div>

	<div>
		<label for="introtext">{{('Intro text:')}}</label>
		<input type="text" name="introtext" value="{!! $article->introtext !!}" >
	</div>

	<div>
		<label for="source">{{('Source:')}}</label>
		<select  name="source" >
			<option> </option>
			@foreach($sources as $source)
		    <option value="{{ $source->id }}" @if($article->source_id == $source->id)  selected @endif>{{ucfirst($source->title) }}</option>
			@endforeach
		</select>
	</div>

<div>
	@if($article->keywords)
	<input name="tags" placeholder="Mots clés" value="{{ $article->keywords }}">
	@else
		<input name="tags" placeholder="Mots clés" value="linfodrome.com,linfodrome.ci,linfodrome,abidjan,cote d'ivoire">
	@endif
</div>
	<div>
	<label for="created_by">{{('Auteur:')}}</label>
	<span>{{ Auth::User()->name}}</span>
        <input type="hidden" name="auth_userid" value="{{ Auth::id() }}">
		<select name="created_by">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" @if($article->created_by == $user->id)  selected @endif>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>

	<div>
		<label for="start_publication_at">{{('Début de publication:')}}</label>
		<input type="text" name="start_publication_at" class="datepicker"  @if(isset($article->start_publication_at)) value='{{ date("d-m-Y H:i:s", strtotime($article->start_publication_at))}}' @endif autocomplete="off" >
	</div>
	<div>
		<label for="stop_publication_at">{{('Fin de publication:')}}</label>
		<input type="text" name="stop_publication_at"  class="datepicker" @if(isset($article->stop_publication_at)) value='{{ date("d-m-Y H:i:s", strtotime($article->stop_publication_at))}}' @endif autocomplete="off">
	</div>
<div class="uk-margin">
		
    <ul  uk-tab>
        <li><a href="#">Contenu</a></li>
        <li><a href="#">Galerie</a></li>
        <li><a href="#">Media</a></li>
        <li><a href="#">fichier join</a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
    	<li>
		<textarea name="fulltext" id="fulltext" >{!! $article->fulltext !!}</textarea>
	</li>
        <li>
		<label for="gallery_photo">{{('Gallerie Photo:')}}</label>
		<input type="text" name="gallery_photo" id="introtext" value="{{ $article->gallery_photo }}" >
        </li>
        <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur, sed do eiusmod.</li>
        <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur, sed do eiusmod.</li>
        
    </ul>
	</div>
</form>
</div>
	<div class="uk-width-1-3">
	 <iframe id="previewIframe" src="" height="600"></iframe> 
	</div>
</div>

@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/jQuery.tagify.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/custom-tagify.js')}}" ></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/custom-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom-jodit.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>

@endsection
@endsection
