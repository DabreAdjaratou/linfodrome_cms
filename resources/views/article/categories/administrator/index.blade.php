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
</table>
@push('js')
<script type="text/javascript">

$(document).ready(function() {
    
    // $('#dataTable_filter label input').addClass('uk-input');
    // $('#dataTable_length label select').addClass('uk-select uk-align-left');

$('#dataTable').DataTable({
	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('article-categories.laratable') }}",
                columns: [
                    { name: 'title' },
                    { name: 'published' },
                    { name: 'edit', orderable: false, searchable: false },
                    { name: 'trash', orderable: false, searchable: false },
                    { name: 'id' },

                ],
            });

 }); 
 

</script>
@endpush
	
	@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@endsection

@section('js')
 
@endsection

@endsection
