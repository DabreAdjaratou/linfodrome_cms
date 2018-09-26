@extends('layouts.administrator.master')
@section('title', 'Billets revision')
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
			<th>{{ ('Article') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Revisions') }}</th>
			                     
		</tr>
	</thead>
	<tbody>
		@foreach($billets as $billet)
		<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $billet->title }}</td>
			<td class="uk-table-expand"> {{ $billet->getCategory->title }}</td>
			<td class="uk-table-expand"> {{ $billet->getAuthor->name }}</td>
			<td class="uk-table-expand"> {{ $billet->created_at }}</td>
			<td class="uk-table-expand">
				@foreach($billet->getRevision as $revision)
{{$revision}} 
				@endforeach
			</td>
			<td></td>
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