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
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Publiée') }}</th>
			<th> {{ ('Modifier') }}</th>
			<th> {{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody> 
@foreach($categories as $category)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
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

@endsection
@push('js')
<script type="text/javascript">

$(document).ready(function() {
    
    // $('#dataTable_filter label input').addClass('uk-input');
    // $('#dataTable_length label select').addClass('uk-select uk-align-left');

$('#dataTable').DataTable({
	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
				
            });
 }); 
 

</script>
@endpush

@endsection
