@extends('layouts.administrator.master')
@section('title', 'Billets categories')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des categories de billets') }}</h3> @endsection 
<a href="{{ route('billet-categories.create') }}">Nouveau</a> 
<a href="{{ route('billet-categories.trash') }}">Corbeille</a> 

<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small" {{--uk-text-small responsive --}}>	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Publiée') }}</th>
			<th> {{ ('Modifier') }}</th>
			<th> {{ ('Supprimer') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody> 
@foreach($categories as $category)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
			<td> {{ ucfirst($category->title) }}</td>
			<td>{{ $category->published }} </td>
			<td> <a href="{{ route('billet-categories.edit',['category'=>$category]) }}" ><span class="uk-text-success">Modifier</span></a>
			</td>
			<td> <a href="{{ route('billet-categories.put-in-trash',['category'=>$category]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>
			</td>
			<td>{{ $category->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.billet-sidebar') @endcomponent 
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
@section('js')

@endsection

@endsection
