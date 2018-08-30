@extends('layouts.administrator.master')
@section('title', 'Create a new article')
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une article ') }}</h3>@endsection 


<form method="POST" action="{{ route('articles.store') }}"  enctype="multipart/form-data" class="">
	@csrf

<button type="submit" name="save_close">{{('Enregistrer & fermer')}}</button>
<button type="submit" name="save_next">{{('Enreg & insérer prochain ')}}</button>
<button type="reset">{{('Annuler')}}</button>
	<div>	
<label for="ontitle">{{('Sur Titre:')}}</label>
<input type="text" name="ontitle" placeholder="Sur titre">
   </div>
<div>
<label for="title">{{('Titre:')}}</label>
<input type="text" name="title" placeholder="Titre" required autofocus>
</div>
<div>
<label for="published">{{('Published:')}}</label>
<input type="checkbox" name="published" value="">

<label for="featured">{{('Featured:')}}</label>
<input type="checkbox" name="featured">
</div>
<div>
<label for="image">{{('Image:')}}</label>
<input type="file" name="image" >
</div>
<div>
<label for="image_legend">{{('Image caption:')}}</label>
<input type="text" name="image_legend" >
</div>

<div>
<label for="video">{{('Video:')}}</label>
<input type="text" name="video" >
</div>

<div>
<label for="gallery_photo">{{('Gallerie Photo:')}}</label>
<input type="text" name="gallery_photo" >
</div>

<div>
<label for="intro_text">{{('Intro text:')}}</label>
<input type="text" name="intro_text" >
</div>

<div>
<label for="full_text">{{('Content:')}}</label>
<textarea name="full_text" id="full_text" ></textarea>
</div>
<div>
<label for="source">{{('Source:')}}</label>
<select  name="source" >
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
<input type="text" name="start_publication_at" >
</div>
<div>
<label for="stop_publication_at">{{('Stop publication at:')}}</label>
<input type="text" name="stop_publication_at" >
</div>

</form>
@section('js')

@endsection
@endsection