@extends('layouts.administrator.master')
@section('title', 'Create a new banner')
@section('css')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Ajouter une bannière ') }}</h3>@endsection 


<form method="POST" action="{{ route('banners.store') }}"  enctype="multipart/form-data" class="">
	@csrf
	<button type="submit" name="save_close" value="save_close">{{('Enregistrer & fermer')}}</button>
	<button type="submit" name="save_next" value="save_next">{{('Enreg & insérer prochain ')}}</button>
	<button type="reset" name="cancel" value="cancel" onclick="window.location.href='{{ route('banners.index') }}'">{{('Annuler')}}</button>
	
	
	<div>
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre"  value="{{ old('title') }}" required autofocus>
	</div>
	<div>
		<label for="type">{{('Type:')}}</label>
		<select name="type">
			<option></option>
			<option value="{{ 0 }}" {{ (old("type") == 0 ? "selected":"") }}>{{ ('Image') }}</option>
			<option value="{{ 1 }}" {{ (old("type") == 1 ? "selected":"") }}>{{ ('Personnalisé') }}</option>
		</select>
	</div>
	<div>
		<label for="category">{{('categorie:')}}</label>
		<select  name="category" >
			<option> </option>
			@foreach($categories as $category)
			<option value="{{ $category->id }}" {{ (old("category") == $category->id ? "selected":"") }}>{{ucfirst($category->title) }}</option>
			@endforeach
		</select>
	</div>
	<div>
		<label for="published">{{('Publié:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}" @if(old('published')) checked @endif>
	</div>
	<div>
		<label for="url">{{('URL:')}}</label>
		<input type="text" name="url" placeholder="URL"  value="{{ old('url') }}" required autofocus>
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
		<label for="start_publication_at">{{('Debut de publication : ')}}</label>
		<input type="text" name="start_publication_at" class="datepicker" value="{{ old('start_publication_at') }}" >
	</div>
	<div>
		<label for="stop_publication_at">{{('Fin de publication:')}}</label>
		<input type="text" name="stop_publication_at" class="datepicker" value="{{ old('stop_publication_at') }}">
	</div>

	<div class="uk-margin">
		
		<ul  uk-tab>
			<li><a href="#">Version ordinateur</a></li>
			<li><a href="#">version tablette</a></li>
			<li><a href="#">version mobile</a></li>
		</ul>

		<ul class="uk-switcher uk-margin">
			<li>
				<div>
					<label for="imageForComputer">{{('Image:')}}</label>
					<input type="file" name="imageForComputer" value="{{ old('imageForComputer') }}" >
				</div>
				<div>
					<label for="sizeForComputer">{{('Taille:')}}</label>
					<input type="text" name="sizeForComputer" placeholder="Taille"  value="{{ old('sizeForComputer') }}" autofocus>
				</div>
				<div>
					<label for="codeForComputer">{{('Code:')}}</label>
					<textarea name="codeForComputer" >{{{ old('codeForComputer') }}}</textarea> 
				</div>
			</li>

			<li>
				<div>
					<label for="imageForTablet">{{('Image:')}}</label>
					<input type="file" name="imageForTablet" value="{{ old('imageForTablet') }}" >
				</div>
				<div>
					<label for="sizeForTablet">{{('Taille:')}}</label>
					<input type="text" name="sizeForTablet" placeholder="Taille"  value="{{ old('sizeForTablet') }}" autofocus>
				</div>
				<div>
					<label for="codeForTablet">{{('Code:')}}</label>
					<textarea name="codeForTablet" >{{{ old('codeForTablet') }}}</textarea> 
				</div> 
			</li>
			<li>
				<div>
					<label for="imageForMobile">{{('Image:')}}</label>
					<input type="file" name="imageForMobile" value="{{ old('imageForMobile') }}" >
				</div>
				<div>
					<label for="sizeForMobile">{{('Taille:')}}</label>
					<input type="text" name="sizeForMobile" placeholder="Taille"  value="{{ old('sizeForMobile') }}" autofocus>
				</div>
				<div>
					<label for="codeForMobile">{{('Code:')}}</label>
					<textarea name="codeForMobile" >{{ old('codeForMobile') }}</textarea> 
				</div>
			</li>

		</ul>
	</div>
</form>

@section('sidebar')
@component('layouts.administrator.banner-sidebar') @endcomponent 
@endsection
@section('js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/custom-datepicker.js') }}"></script>
@endsection
@endsection