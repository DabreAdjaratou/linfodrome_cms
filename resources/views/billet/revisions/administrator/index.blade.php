@extends('layouts.administrator.master')
@section('title', 'Billets revisions')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des revisions') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >	
	<thead>
		<tr>
			<th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Billet') }}</th>
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
			<td class="uk-table-expand"> {{ $revision[$i]->getBillet->title }}</td>
			<td class="uk-table-expand"> {{ $revision[$i]->getBillet->getCategory->title }}</td>
			<td class="uk-table-expand"> {{ $revision[$i]->getBillet->getAuthor->name }}</td>
			<td class="uk-table-expand"> {{ $revision[$i]->getBillet->created_at }}</td>
			
			<td class="uk-table-expand">
				<ul> <li >{{$revision[$i]->type}} 
				{{$revision[$i]->getModifier->name}} 
				{{$revision[$i]->revised_at}}</ul> </li >
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
	@component('layouts.administrator.billet-sidebar') @endcomponent 
	@endsection

	@section('js')

	@endsection

	@endsection