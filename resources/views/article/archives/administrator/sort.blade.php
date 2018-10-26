@extends('layouts.administrator.master')
@section('title', 'Videos list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des videos') }}</h3> @endsection 
<a href="{{ route('videos.create') }}">Nouveau</a> 
<table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;">
        <thead>
            <tr>
                <th>Target</th>
                <th>Search text</th>
                <th>Treat as regex</th>
                <th>Use smart search</th>
            </tr>
        </thead>
        <tbody>
            <tr id="filter_global">
                <td>Global search</td>
                <td align="center"><input type="text" namem="global_filter" class="global_filter" id="global_filter"></td>
                <td align="center"><input type="checkbox" class="global_filter" id="global_regex"></td>
                <td align="center"><input type="checkbox" class="global_filter" id="global_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col1" data-column="0">
                <td>Column - Title</td>
                <td align="center"><input type="text" class="column_filter" id="col0_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col0_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col0_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col2" data-column="1">
                <td>Column - Categorie</td>
                <td align="center"><input type="text" class="column_filter" id="col1_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col1_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col1_smart" checked="checked"></td>
            </tr>
            
        </tbody>
    </table>

<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive">	
	<thead>
            <tr>
            {{-- <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th> --}}
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Categorie') }}</th>
			<th>{{ ('A la Une') }}</th>
			<th>{{ ('Publiée') }}</th>
			<th>{{ ('Journaliste') }}</th>
			<th>{{ ('Cameraman') }}</th>
			<th>{{ ('Monteur') }}</th>
			<th>{{ ('crée lé') }}</th>
			<th>{{ ('Debut publication') }}</th>
			<th>{{ ('fin publication') }}</th>
			<th>{{ ('Nbre de vue') }}</th>
                        <th>{{ ('Modifier') }}</th>
                        <th>{{ ('Brouillon') }}</th>
                        <th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
{{-- 	<tbody>		
		@foreach($videos as $video)		
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
            <td class="uk-table-expand"> {{ ucfirst($video->title) }}</td>
			<td class="uk-table-expand"> {{$video->getCategory->title}}</td>
			<td> {{ $video->featured }}</td>
			<td> {{ $video->published }}</td>
			<td class="uk-table-expand"> {{ucwords($video->getAuthor->name)}}</td>
			<td class="uk-table-expand"> {{ucwords($video->getCameraman->name)}}</td>
			<td class="uk-table-expand"> {{ucwords($video->getEditor->name)}}  </td>
			<td class="uk-table-expand">{{$video->created_at}}</td>
			<td class="uk-table-expand">{{ $video->start_publication_at}} </td>
			<td class="uk-table-expand"> {{$video->stop_publication_at}}</td>
			<td> {{$video->views}}</td>
                        <td> <a href="{{ route('videos.edit',['video'=>$video]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
                        <td> <a href="{{ route('videos.put-in-draft',['video'=>$video]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a>

			</td>
                        <td> <a href="{{ route('videos.put-in-trash',['video'=>$video]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>

			</td>
			<td>{{ $video->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot> --}}
</table>
@section('sidebar')
 @component('layouts.administrator.video-sidebar') @endcomponent 
@endsection
@push('js')
<script type="text/javascript">
$(document).ready(function() {
    
    // $('#dataTable_filter label input').addClass('uk-input');
    // $('#dataTable_length label select').addClass('uk-select uk-align-left');

var table=$('#dataTable').DataTable({
	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				serverSide: true,
                processing: true,
                responsive: true,
                searching: false,
                ajax: "{{ route('videos.laratable') }}", 
                columns: [
                    { name: 'title' },
                    { name: 'getcategory.title' },
                    { name: 'featured' },
                    { name: 'published' },
                    { name: 'getauthor.name' },
                    { name: 'getcameraman.name' },
                    { name: 'geteditor.name' },
                    { name: 'created_at' },
                    { name: 'start_publication_at' },
                    { name: 'stop_publication_at' },
                    { name: 'views' },
                    { name: 'edit', orderable: false, searchable: false },
                    { name: 'draft', orderable: false, searchable: false },
                    { name: 'trash', orderable: false, searchable: false },
                    { name: 'id' },
                ],

        } );

function filterGlobal () {
    $('#dataTable').DataTable().search(
        $('#global_filter').val(),
        $('#global_regex').prop('checked'),
        $('#global_smart').prop('checked')
    ).draw();
}
 
function filterColumn ( i ) {
    $('#dataTable').DataTable().column( i ).search(
        $('#col'+i+'_filter').val(),
        $('#col'+i+'_regex').prop('checked'),
        $('#col'+i+'_smart').prop('checked')
    ).draw();
}
 
$(document).ready(function() {
    $('#dataTable').DataTable();
 
    $('input.global_filter').on( 'keyup click', function () {
        filterGlobal();
    } );
 
    $('input.column_filter').on( 'keyup click', function () {
        filterColumn( $(this).parents('tr').attr('data-column') );
    } );
} );
  }); 
</script>
@endpush
@section('js')

@endsection

@endsection
