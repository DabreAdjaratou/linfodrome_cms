@extends('layouts.administrator.master')
@section('title', 'Edit a banner')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{asset('css/tagify.css')}}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"
@endsection
@section('content')
@section('pageTitle') <h3> {{ ('Modifier une bannière ') }}</h3>@endsection 


<form method="POST" action="{{ route('banners.update',['banner'=>$banner]) }}"  enctype="multipart/form-data" class="">
	@csrf
	@method('put')
	<div>
		<button type="submit" name="update" value="update">{{ ('Modifier') }}</button>
		<button type="submit" name="cancel" value="cancel"> {{ ('Annuler') }}</button>
	</div>
	<div>
		<label for="title">{{('Titre:')}}</label>
		<input type="text" name="title" placeholder="Titre"  value="{{ $banner->title }}" required autofocus>
	</div>
	<div>
		<label for="type">{{('Type:')}}</label>
		<select name="type">
			<option></option>
			<option value="{{ 0 }}" {{ $banner->type == 0 ? "selected":"" }}>{{ ('Image') }}</option>
			<option value="{{ 1 }}" {{ $banner->type == 1 ? "selected":"" }}>{{ ('Personnalisé') }}</option>
		</select>
	</div>
	<div>
	<label for="category">{{('categorie:')}}</label>
	<select  name="category" >
		<option> </option>
		@foreach($categories as $category)
		<option value="{{ $category->id }}" {{ $banner->category_id == $category->id ? "selected":"" }}>{{ucfirst($category->title) }}</option>
		@endforeach
	</select>
	</div>
	<div>
		<label for="published">{{('Publié:')}}</label>
		<input type="checkbox" name="published" value="{{ 1 }}" @if($banner->published==1) checked @endif>
	</div>
	<div>
		<label for="url">{{('URL:')}}</label>
		<input type="text" name="url" placeholder="URL"  value="{{ $banner->url}}" required autofocus>
	</div>
	
	<div>
	<label for="created_by">{{('Auteur:')}}</label>
	<span>{{ Auth::User()->name}}</span>
        <input type="hidden" name="auth_userid" value="{{ Auth::id() }}">
		<select name="created_by">
			<option></option>
			@foreach ($users as $user)
			<option value="{{ $user->id }}" {{ $banner->created_by == $user->id ? "selected":"" }}>{{ $user->name }} </option>
			@endforeach 
		</select>
	</div>

	<div>
		<label for="start_publication_at">{{('Debut de publication :')}}</label>
		<input type="text" name="start_publication_at" class="datepicker"  @if(isset($banner->start_publication_at)) value='{{ date("d-m-Y H:i:s", strtotime($banner->start_publication_at))}}' @endif autocomplete="off"  >
	</div>
	<div>
		<label for="stop_publication_at">{{('Fin de publication :')}}</label>
		<input type="text" name="stop_publication_at"  class="datepicker"  @if(isset($banner->stop_publication_at)) value='{{ date("d-m-Y H:i:s", strtotime($banner->stop_publication_at))}}' @endif autocomplete="off" >
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
					<input type="file" name="imageForComputer" value="" >
				</div>
				<div>
					<label for="sizeForComputer">{{('Taille:')}}</label>
					<input type="text" name="sizeForComputer" placeholder="Taille"  autofocus value="{{ json_decode($banner->size)->computer}}">
				</div>
				<div>
					<label for="codeForComputer">{{('Code:')}}</label>
					<textarea name="codeForComputer" >{{ json_decode($banner->code)->computer}}</textarea> 
				</div>
			</li>

			<li>
				<div>
					<label for="imageForTablet">{{('Image:')}}</label>
					<input type="file" name="imageForTablet"  >
				</div>
				<div>
					<label for="sizeForTablet">{{('Taille:')}}</label>
					<input type="text" name="sizeForTablet" placeholder="Taille"  value="{{ json_decode($banner->size)->tablet}}" autofocus>
				</div>
				<div>
					<label for="codeForTablet">{{('Code:')}}</label>
					<textarea name="codeForTablet" >{{ json_decode($banner->code)->tablet}}</textarea> 
				</div> 
			</li>
			<li>
				<div>
					<label for="imageForMobile">{{('Image:')}}</label>
					<input type="file" name="imageForMobile"  >
				</div>
				<div>
					<label for="sizeForMobile">{{('Taille:')}}</label>
					<input type="text" name="sizeForMobile" placeholder="Taille"  value="{{ json_decode($banner->size)->mobile}}"  autofocus>
				</div>
				<div>
					<label for="codeForMobile">{{('Code:')}}</label>
					<textarea name="codeForMobile" >{{ json_decode($banner->code)->mobile}}</textarea> 
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