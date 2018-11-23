@extends('layouts.administrator.master')
@section('title', 'Videos revisions')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des revisions') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
		<tr>
			<th style="width: 25%">{{ ('Video') }}<i class="fas fa-sort uk-margin-left"></i></th>
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
			<td> {{ $revision[$i]->getVideo->title }}</td>
			<td> {{ $revision[$i]->getVideo->getCategory->title }}</td>
			<td> {{ $revision[$i]->getVideo->getAuthor->name }}</td>
			<td> {{ $revision[$i]->getVideo->created_at }}</td>
			<td> <a href="{{ route('video-revisions.show',['revision'=>$revision[$i]->getVideo->id]) }}" >{{ ('Revisions') }} </a></td>
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
	@component('layouts.administrator.video-sidebar') @endcomponent 
	@endsection
	@section('js')
 <script type="text/javascript" src="{{ asset('js/custom-datatable.js') }}"></script>
	@endsection
	@endsection