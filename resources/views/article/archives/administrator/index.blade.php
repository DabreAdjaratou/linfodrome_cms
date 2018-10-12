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
            {{-- <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th> --}}
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
			<th>{{ ('Modifié') }} </th>
            <th>{{ ('Brouillon') }} </th>
			<th> {{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>
	</thead>
	{{-- <tbody>
		@foreach($articles as $article)
		<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $article->title }}</td>
			<td> {{ $article->featured }}</td>
			<td> {{ $article->published }}</td>
			<td> </td>
			<td> </td> --}}
			{{-- <td class="uk-table-expand"> {{ $article->getCategory->title }}</td> --}}
			{{-- <td class="uk-table-expand"> {{ $article->getAuthor->name }}</td> --}}
{{-- 			<td class="uk-table-expand"> {{ $article->created_at }}</td>
<td> </td><td> </td> --}}
			{{-- <td class="uk-table-expand">{{$article->getRevision->last()['getModifier']['name']}} </td> --}}
			{{-- <td class="uk-table-expand">{{$article->getRevision->last()['revised_at']}}  </td> --}}
			{{-- <td> {{ $article->views }}</td>
			<td> {{ $article->image }}</td>
			<td> <a href="{{ route('article-archives.edit',['article'=>$article]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
                        <td> <a href="{{ route('articles.put-in-draft',['article'=>$article]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a>

			</td>
			 <td> <a href="{{ route('article-archives.put-in-trash',['article'=>$article]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>

			</td>
			<td>{{ $article->id }}</td>
                </tr>
		@endforeach --}}
{{-- 	</tbody>
	<tfoot>
	</tfoot> --}}
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
                ajax: "{{ route('article-archives.laratable') }}",
                columns: [
                    // { name: 'title' },
                    // { name: 'published' },
                    // // { name: 'edit', orderable: false, searchable: false },
                    // // { name: 'trash', orderable: false, searchable: false },
                    // { name: 'id' },

                ],
            });

 }); 
@endpush
@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@endsection
@section('js')

@endsection

@endsection