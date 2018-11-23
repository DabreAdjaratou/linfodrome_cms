@extends('layouts.administrator.master')
@section('title', 'Billets revision')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des revisions') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small" >	
	<thead>
		<tr>
			<th style="width: 25%">{{ ('billet') }}<i class="fas fa-sort uk-margin-left"></i></th>
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
			<td> {{ $revision[$i]->getBillet->title }}</td>
			<td> {{ $revision[$i]->getBillet->getCategory->title }}</td>
			<td> {{ $revision[$i]->getBillet->getAuthor->name }}</td>
			<td> {{ $revision[$i]->getBillet->created_at }}</td>
			<td> <a href="{{ route('billet-revisions.show',['revision'=>$revision[$i]->getBillet->id]) }}" >{{ ('Revisions') }} </a></td>
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
	@component('layouts.administrator.billet-sidebar') @endcomponent 
	@endsection
	@section('js')
 <script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>
	@endsection
	@endsection