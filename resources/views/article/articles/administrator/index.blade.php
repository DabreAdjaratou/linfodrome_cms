@extends('layouts.administrator.master')
@section('title', 'Articles list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des articles') }}</h3> @endsection
<a href="{{ route('articles.create') }}">Nouveau</a> 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
            <tr>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('A la une') }}</th>
			<th>{{ ('Publiée') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Dernière modification') }}</th>
			<th>{{ ('Modifié le') }}</th>
			<th>{{ ('Nbre de vue') }}</th>
			<th>{{ ('Image') }}</th>
			<th>{{ ('Modifier') }}</th>
            <th>{{ ('brouillon') }}</th>
			<th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>
	</thead>
	

</table>
@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@push('js')
<script type="text/javascript">
$(document).ready(function() {
    
 $('#dataTable').DataTable({
	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
	serverSide: true,
                processing: true,
                responsive: true,
                ajax: "{{ route('articles.laratable') }}",
                 columns: [
                    { name: 'title' },
                    { name: 'featured' },
                    { name: 'published' },
                    { name: 'getcategory.title' },
                    { name: 'getauthor.name' },
                    { name: 'created_at' },
                    { name: 'lastupdatedby',orderable: false, searchable: false },
                    { name: 'lastupdatedat' ,orderable: false, searchable: false},
                    { name: 'views' },
                    { name: 'image' },
                    { name: 'edit', orderable: false, searchable: false },
                    { name: 'draft', orderable: false, searchable: false },
                    { name: 'trash', orderable: false, searchable: false },
                    { name: 'id' },
                ],
                });
				
 }); 

</script>
@endpush

@endsection

@section('js')

@endsection

@endsection