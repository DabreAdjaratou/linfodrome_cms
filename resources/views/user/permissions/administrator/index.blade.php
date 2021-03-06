@extends('layouts.administrator.master')
@section('title', 'Permissions list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des Permissions') }}</h3> @endsection 
<div class="uk-margin ">	
	<a href="{{ route('permissions.create') }}">Nouveau</a>
</div>

@foreach($permissions as $permission)


@for($i=0; $i<count($permission); $i++)

@if($i==0)
<div> <a href="{{ route('permissions.edit',['permission'=>$permission[$i]->getAccessLevel->id]) }}">{{ $permission[$i]->getAccessLevel->title }}</a></div>
 <form action="{{ route('permissions.destroy',['permission'=> $permission[$i]->getAccessLevel->id]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer cette categorie?')">
				@csrf
				@method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
			</form> 
<div>	{{ $permission[$i]->getResource->display_name }}</div>
{{ $permission[$i]->getAction->title}} 
@else
@php $i2=$i - 1 ;@endphp

@if ($permission[$i]->getResource->title==$permission[$i2]->getResource->title) 
	{{ $permission[$i]->getAction->title}}
@else
<div>	{{ $permission[$i]->getResource->display_name}}</div>
{{ $permission[$i]->getAction->title }} 


@endif


			
@endif

@endfor

@endforeach
	
@section('sidebar')
 @component('layouts.administrator.user-sidebar') @endcomponent 
@endsection

@section('js')

@endsection

@endsection




