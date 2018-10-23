@extends('layouts.administrator.master')
@section('title', 'Articles categories')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des categories d\'articles') }}</h3> @endsection 
<a href="{{ route('article-categories.create') }}">Nouveau</a> 
<a href="{{ route('article-categories.trash') }}">Corbeille</a> 

<div class="uk-margin ">	
	@can('create', App\Models\Article\Category::class)
    <div>a le droit</div>
@endcan
</div>
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small">	
	<thead>
            <tr>
            {{-- <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th> --}}
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Pulieé') }}</th>
			<th> {{ ('Modifier') }}</th>
			<th> {{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>

                       
		</tr>
	</thead>
	<tbody> 
@foreach($categories as $category)
		<tr>
			{{-- <td><input type="checkbox" name="" class="uk-checkbox"></td> --}}
		<td><a href="{{ route('article-categories.edit',['category'=>$category]) }}" >{{ ucfirst($category->title) }}</a></td>
			<td>{{ $category->published }} </td>
			<td> <a href="{{ route('article-categories.edit',['category'=>$category]) }}" ><span class="uk-text-success">Modifier</span></a>
			</td>
			<td> <a href="{{ route('article-categories.put-in-trash',['category'=>$category]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>
			</td>
			<td>{{ $category->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot> 
	</tfoot>
</table>
	@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@endsection

@section('js')
 
@endsection

@push('js')
<script type="text/javascript">

$(document).ready(function() {
    
$('#dataTable').DataTable({
	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
				 }); 

 }); 
 

</script>
@endpush

@endsection
