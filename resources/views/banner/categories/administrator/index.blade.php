@extends('layouts.administrator.master')
@section('title', 'Banners categories')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des categories de bannières') }}</h3> @endsection 
<a href="{{ route('banner-categories.create') }}">Nouveau</a> 
<a href="{{ route('banner-categories.trash') }}">Corbeille</a> 

<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small" {{--uk-text-small responsive --}}>	
	<thead>
            <tr>
           <th>{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('Publiée') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('Modifier') }}</th>
			<th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}<i class="fas fa-sort uk-margin-left"></i></th>
                       
                       
		</tr>
	</thead>
	<tbody> 
@foreach($categories as $category)
		<tr>
			<td><a href="{{ route('banner-categories.edit',['category'=>$category]) }}" > {{ ucfirst($category->title) }}</a></td>
			<td>{{ $category->published }} </td>
			<td> <a href="{{ route('banner-categories.edit',['category'=>$category]) }}" ><span class="uk-text-success">Modifier</span></a>
			</td>
			<td> <a href="{{ route('banner-categories.put-in-trash',['category'=>$category]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>
			</td>
			<td>{{ $category->id }}</td>
                </tr>
		@endforeach
	</tbody>
		</table>

@section('sidebar')
@component('layouts.administrator.banner-sidebar') @endcomponent 
@endsection
@section('js')
 <script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>

@endsection

@endsection
