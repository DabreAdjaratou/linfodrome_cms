@extends('layouts.administrator.master')
@section('title', 'Video revision')
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
			<th>{{ ('Video') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Revisions') }}</th>
			                     
		</tr>
	</thead>
	<tbody>
		@foreach($videos as $video)
		<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $video->title }}</td>
			<td class="uk-table-expand"> {{ $video->getCategory->title }}</td>
			<td class="uk-table-expand"> {{ $video->getAuthor->name }}</td>
			<td class="uk-table-expand"> {{ $video->created_at }}</td>
			<td class="uk-table-expand">
				@foreach($video->getRevision as $revision)
{{'-'.$revision->type}} 
{{$revision->getModifier->name}} 
{{$revision->revised_at}} <br>
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
 @component('layouts.administrator.video-sidebar') @endcomponent 
@endsection

@section('js')

@endsection

@endsection