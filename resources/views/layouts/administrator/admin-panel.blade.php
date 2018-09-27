@extends('layouts.administrator.master')
@section('title'){{config('app.name').'-Panneau d\'administration'}} @endsection
@section('css')
@endsection
@section('content')
@section('pageTitle') <h3> {{('Panneau d\'administration')}}</h3>@endsection 

{{ Auth::user()->name }}
<form action="{{ route('logout') }}" method="POST" id="logout">
				@csrf
				@method('post')
<button class="uk-button uk-button-link"><span class="uk-text-danger">logout</span></button>
			</form> 

<ul>
	<li><a href="{{ route('articles.index') }}">{{ ('Articles') }}</a></li>
	<li><a href="{{ route('article-archives.index') }}">{{ ('Archives') }}</a></li>
	<li><a href="{{ route('article-categories.index') }}">{{ ('Categories d\'articles') }}</a></li>   
	<li><a href="{{ route('article-sources.index') }}">{{ ('Sources') }} </a></li>
	<li><a href="{{ route('article-revisions') }}">{{ ('Revions des articles') }} </a></li>
	<li><a href="{{ route('articles.trash') }}">{{ ('Articles en corbeille') }} </a></li>
	<li><a href="{{ route('articles.draft') }}">{{ ('Brouillons') }} </a></li>
</ul>

<ul>
	<li><a href="{{ route('banners.index') }}">{{ ('Banières') }}</a></li>
	<li><a href="{{ route('banner-categories.index') }}">{{ ('Categories de bannières') }}</a></li>   
	<li><a href="{{ route('banners.trash') }}">{{ ('Bannières en corbeille') }} </a></li>
</ul>

<ul>
	<li><a href="{{ route('billets.index') }}">{{ ('Billets') }}</a></li>
    <li><a href="{{ route('billet-archives.index') }}">{{ ('Archives') }}</a></li>
	<li><a href="{{ route('billet-categories.index') }}">{{ ('Categories de billets') }}</a></li>   
	<li><a href="{{ route('billet-sources.index') }}">{{ ('Sources de billets') }}</a></li>
	<li><a href="{{ route('billet-revisions') }}">{{ ('Revisions de billets') }}</a></li>
	<li><a href="{{ route('billets.trash') }}">{{ ('Billets en corbeille') }} </a></li>
	<li><a href="{{ route('billets.draft') }}">{{ ('Brouillons') }} </a></li>

</ul>
<ul>
	<li><a href="{{route('users.index')}}">{{('Utilisateurs') }}</a></li>
	<li><a href="{{route('user-groups.index')}}">{{ ('Group d\'utilisateurs') }}</a></li>   
	<li><a href="{{route('access-levels.index')}}">{{ ('Niveau d\'accès') }}</a></li>
    <li><a href="{{route('resources.index')}}">{{ ('Ressource') }}</a></li>
    <li><a href="{{route('actions.index')}}">{{ ('Action') }}</a></li>
    <li><a href="{{route('permissions.index')}}">{{ ('Permissions') }}</a></li>
</ul>
<ul>
	<li><a href="{{ route('videos.index') }}">{{ ('Videos') }}</a></li>
    <li><a href="{{ route('video-archives.index') }}">{{ ('Archives') }}</a></li>
	<li><a href="{{ route('video-categories.index') }}">{{ ('Categories de videos') }}</a></li>   
	<li><a href="{{ route('video-revisions') }}">{{ ('Revisions de videos') }}</a></li>
	<li><a href="{{ route('videos.trash') }}">{{ ('Video en corbeille') }} </a></li>
	<li><a href="{{ route('videos.draft') }}">{{ ('Brouillons') }} </a></li>
</ul>  

<ul>
	<li><a href="{{ route('media') }}">{{ ('Media') }}</a></li>
    
</ul> 

@endsection
