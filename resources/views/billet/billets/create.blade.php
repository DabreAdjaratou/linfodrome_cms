@extends('layouts.administrator.master')
@section('title', 'Create a new billet')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une billet ') }}</h3>@endsection 


<form method="POST" action="{{ route('billets.store') }}"  enctype="multipart/form-data" class="">
	@csrf
<button type="submit" name="save_close">{{('Enregistrer & fermer')}}</button>
<button type="submit" name="save_next">{{('Enreg & insérer prochain ')}}</button>
<button type="reset">{{('Annuler')}}</button>
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
<option value="{{ $category->id }}">{{ucfirst($category->title) }}</option>
	 @endforeach
</select>
<div>
<label for="published">{{('Published:')}}</label>
<input type="checkbox" name="published" value="{{ 1 }}">

<label for="featured">{{('Featured:')}}</label>
<input type="checkbox" name="featured" value="{{1 }}">
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
<label for="video">{{('Video:')}}</label>
<input type="text" name="video" value="{{ old('video') }}" >
</div>

<div>
<label for="introtext">{{('Intro text:')}}</label>
<input type="text" name="introtext"  value="{{ old('introtext') }}">
</div>

<div>
<label for="fulltext">{{('Content:')}}</label>
<textarea name="fulltext" id="fulltext" value="{{ old('fulltext') }}"></textarea>
</div>
<div>
<label for="source">{{('Source:')}}</label>
<select  name="source" >
	<option> </option>
	 @foreach($sources as $source)
<option value="{{ $source->id }}">{{ucfirst($source->title) }}</option>
	 @endforeach
</select>
</div>

<div>
	</span><label for="created_by">{{('Auteur:')}}</label>
<span>{{ $auth_username }}
<select name="created_by">
	<option></option>
@foreach ($users as $user)
<option value="{{ $user->id }}">{{ $user->name }} </option>
@endforeach 
 </select>
</div>

<div>
<label for="start_publication_at">{{('Star publication at:')}}</label>
<input type="text" name="start_publication_at" value="{{ old('start_publication_at') }}">
</div>
<div>
<label for="stop_publication_at">{{('Stop publication at:')}}</label>
<input type="text" name="stop_publication_at" value="{{ old('stop_publication_at') }}">
</div>

</form>
@section('js')

@endsection
@endsection