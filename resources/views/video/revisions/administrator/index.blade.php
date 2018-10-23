@extends('layouts.administrator.master')
@section('title', 'Videos revisions')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des revisions de video') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
		<tr>
			<th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Video') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Revisions') }}</th>

		</tr>
	</thead>
	<tbody>
		<tr class="uk-text-small">
			@foreach($revisions as $revision)
			@for($i=0; $i<count($revision); $i++)
			@if($i==0)
			{{-- {{ dd($revision[$i]) }} --}}
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td><a href="{{ route('video-revisions.show',['revision'=>$revision[$i]]) }}" > {{ $revision[$i]->getVideo->title }}</td>
			<td> {{ $revision[$i]->getVideo->getCategory->title }}</td>
			<td> {{ $revision[$i]->getVideo->getAuthor->name }}</td>
			<td> {{ $revision[$i]->getVideo->created_at }}</td>
			
			<td>
				<ul> <li >{{$revision[$i]->type}} 
				{{$revision[$i]->getModifier->name}} 
				{{$revision[$i]->revised_at}} </ul> </li >
				@else
				
				<ul> <li >{{$revision[$i]->type}} 
				{{$revision[$i]->getModifier->name}} 
				{{$revision[$i]->revised_at}} </ul> </li>

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

	@endsection

	@endsection