@extends('layouts.administrator.master')
@section('title', 'Create a new billet')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/tagify.css')}}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une billet ') }}</h3>@endsection 


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
<input type="text" name="title" placeholder="Titre" value="{{ old('title') }}" required autofocus>
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

<label for="featured">{{('Featured:')}}</label>
<input type="checkbox" name="featured" value="{{1 }}" @if(old('featured')) checked @endif>
</div>
<div>
<label for="image">{{('Image:')}}</label>
<input type="file" name="image" value="{{ old('image') }}" >
</div>
<div>
<label for="image_legend">{{('Image caption:')}}</label>
<input type="text" name="image_legend" value="{{ old('image_legend') }}" >
</div>
<div>
<label for="introtext">{{('Intro text:')}}</label>
<input type="text" name="introtext"  value="{{ old('introtext') }}">
</div>

<div>
<label for="fulltext">{{('Content:')}}</label>
<textarea name="fulltext" id="fulltext" >{{ old('fulltext') }}</textarea>
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
<label for="start_publication_at">{{('Star publication at:')}}</label>
<input type="text" name="start_publication_at" class="datepicker" value="{{ old('start_publication_at') }}">
</div>
<div>
<label for="stop_publication_at">{{('Stop publication at:')}}</label>
<input type="text" name="stop_publication_at" class="datepicker" value="{{ old('stop_publication_at') }}">
</div>

</form>
@section('sidebar')
 @component('layouts.administrator.billet-sidebar') @endcomponent 
@endsection
@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{asset('js/jQuery.tagify.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/custom-tagify.js')}}" ></script>
<script type="text/javascript" src="{{ asset('js/custom-datepicker.js') }}"></script>
@endsection
@endsection