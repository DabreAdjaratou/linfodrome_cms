@extends('layouts.administrator.master')
@section('title', 'Videos list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des videos') }}</h3> @endsection 
<a href="{{ route('videos.create') }}">Nouveau</a> 
<input type="search" name="title" id="title">
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive">	
	<thead>
            <tr>
            {{-- <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th> --}}
			<th>{{ ('Titre de la video') }}</th>
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
 $('#title').on( 'keyup', function (event) {
    table.columns( 0 ).search( this.value ).draw();
 }); 
 }); 
</script>
@endpush
@section('js')

@endsection

@endsection
