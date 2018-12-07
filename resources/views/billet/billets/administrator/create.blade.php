@extends('layouts.administrator.master')
@section('title', 'Create a new billet')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/tagify.css')}}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une billet ') }}</h3>@endsection 

<div class="uk-grid">
	<div class="uk-width-2-3">
<form method="POST" action="{{ route('billets.store') }}"  enctype="multipart/form-data" class="">
	@csrf
        <button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
        <button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
		<button type="reset" name="cancel" value="cancel" onclick="window.location.href='{{ route('billets.index') }}'">{{('Annuler')}}</button>

	<div>	
<label for="ontitle">{{('Sur Titre:')}}</label>
<input type="text" name="ontitle" placeholder="Sur titre" value="{{ old('ontitle') }}">
   </div>
<div>
<label for="title">{{('Titre:')}}</label>
<input type="text" name="title" id="title" placeholder="Titre" value="{{ old('title') }}" required autofocus>
</div>
<label for="category">{{('Categorie:')}}</label>
<select  name="category" >
	<option> </option>
	 @foreach($categories as $category)
<option value="{{ $category->id }}" {{ (old("category") == $category->id ? "selected":"") }}>{{ucfirst($category->title) }}</option>
	 @endforeach
</select>
<div>
<label for="published">{{('Publié:')}}</label>
<input type="checkbox" name="published" value="{{ 1 }}" @if(old('published')) checked @endif>

<label for="featured">{{('En vedette:')}}</label>
<input type="checkbox" name="featured" value="{{1 }}" @if(old('featured')) checked @endif>
</div>
<div>
<label for="image">{{('Image:')}}</label>
<input type="file" name="image" value="{{ old('image') }}" >
</div>
<div>
<label for="image_legend">{{('Legende:')}}</label>
<input type="text" name="image_legend" value="{{ old('image_legend') }}" >
</div>
<div>
<label for="introtext">{{('Intro text:')}}</label>
<input type="text" name="introtext" id="introtext" value="{{ old('introtext') }}">
</div>
<div>
	<div>
	<input name="tags" placeholder="write some tags" value="linfodrome.com,linfodrome.ci,linfodrome,abidjan,cote d'ivoire">
</div>
<label for="source">{{('Source:')}}</label>
<select  name="source" >
	<option> </option>
	 @foreach($sources as $source)
<option value="{{ $source->id }}" {{ (old("source") == $source->id ? "selected":"") }}>{{ucfirst($source->title) }}</option>
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
<option value="{{ $user->id }}" {{ (old("created_by") == $user->id ? "selected":"") }}>{{ $user->name }} </option>
@endforeach 
 </select>
</div>

<div>
<label for="start_publication_at">{{('Debut de publication:')}}</label>
<input type="text" name="start_publication_at" class="datepicker" value="{{ old('start_publication_at') }}">
</div>
<div>
<label for="stop_publication_at">{{('Fin de publication:')}}</label>
<input type="text" name="stop_publication_at" class="datepicker" value="{{ old('stop_publication_at') }}">
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
		<textarea name="fulltext" id="fulltext" >{{old('fulltext')}}</textarea>
	</li>
        <li>
		<label for="gallery_photo">{{('Creer une gallerie photos:')}}</label>
		<input type="text" name="gallery_photo"  >
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
 @component('layouts.administrator.billet-sidebar') @endcomponent 
@endsection
@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{asset('js/jQuery.tagify.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/custom-tagify.js')}}" ></script>
<script type="text/javascript" src="{{ asset('js/custom-datepicker.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>
<script type="text/javascript" src="{{ asset('js/custom-jodit.js') }}"></script>
@endsection
@endsection