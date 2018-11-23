@extends('layouts.administrator.master')
@section('title', 'Articles revision')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des revisions') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
		<tr>
			<th style="width: 25%">{{ ('Article') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('Category') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('Auteur') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('créé le') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('Revisions') }}</th>
			<th>{{ ('Nombre') }}<i class="fas fa-sort uk-margin-left"></i></th>

		</tr>
	</thead>
	<tbody>
		<tr>
			@foreach($revisions as $revision)
			@for($i=0; $i<count($revision); $i++)
			@if($i==0)
			<td> {{ $revision[$i]->getArticle->title }}</td>
			<td> {{ $revision[$i]->getArticle->getCategory->title }}</td>
			<td> {{ $revision[$i]->getArticle->getAuthor->name }}</td>
			<td> {{ $revision[$i]->getArticle->created_at }}</td>
			<td> <a href="{{ route('article-revisions.show',['revision'=>$revision[$i]->getArticle->id]) }}" >{{ ('Revisions') }} </a></td>
			<td>
				{{count($revision)}}
				
				@endif
				@endfor
			</td>
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
 <script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>
	@endsection
	@endsection