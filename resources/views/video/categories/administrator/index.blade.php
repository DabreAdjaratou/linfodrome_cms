@extends('layouts.administrator.master')
@section('title', 'Videos categories')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des categories de video') }}</h3> @endsection 
<a href="{{ route('video-categories.create') }}">Nouveau</a> 
<a href="{{ route('video-categories.trash') }}">Corbeille</a> 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small" {{--uk-text-small responsive --}}>	
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
			<td><a href="{{ route('video-categories.edit',['category'=>$category]) }}" > {{ ucfirst($category->title) }}</a></td>
			<td>{{ $category->published }} </td>
			<td> <a href="{{ route('video-categories.edit',['category'=>$category]) }}" ><span class="uk-text-success">Modifier</span></a>
			</td>
			<td> <a href="{{ route('video-categories.put-in-trash',['category'=>$category]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>
			</td>
			<td>{{ $category->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.video-sidebar') @endcomponent 
@endsection

@section('js')

 <script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>

@endsection

@endsection
