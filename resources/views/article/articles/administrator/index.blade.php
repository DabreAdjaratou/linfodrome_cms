@extends('layouts.administrator.master')
@section('title', 'Articles list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des articles') }}</h3> @endsection
<a href="{{ route('articles.create') }}">Nouveau</a> 
<input type="text" name="title" id="title">
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
    
 var table=$('#dataTable').DataTable({
	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                ajax: "{{ route('articles.test') }}",
                 columns: [
                 { data: 'id' },
                 // { data: 'name' },
                 // { data: 'position' },
                 // { data: 'salary' },
                    // { data: 'title' },
                    // { data: 'featured' },
                    // { data: 'published' },
                    // { data: 'getcategory.title' },
                    // { data: 'getauthor.name' },
                    // { data: 'created_at' },
                    // { data: 'lastupdatedby',orderable: false, searchable: false },
                    // { data: 'lastupdatedat' ,orderable: false, searchable: false},
                    // { data: 'views' },
                    // { data: 'image' },
                    // { data: 'edit', orderable: false, searchable: false },
                    // { data: 'draft', orderable: false, searchable: false },
                    // { data: 'trash', orderable: false, searchable: false },
                    // { data: 'id' },
                ],
                });
				
                 $('#title').on( 'keyup', function (event) {
    table.columns( 1 ).search( this.value ).draw();
 }); 
 }); 

</script>
@endpush

@endsection

@section('js')

@endsection

@endsection
@php
$fp = fopen(base_path('/resources/views/article/articles/administrator/test.blade.php'), 'w');
foreach ($articles as $a) {
    $data=json_encode($a).',';
fwrite($fp,$data);
}
fclose($fp);
@endphp