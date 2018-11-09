@extends('layouts.administrator.master')
@section('title', 'Billets sources')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des sources de billets') }}</h3> @endsection 
<a href="{{ route('billet-sources.create') }}">Nouveau</a> 
<a href="{{ route('billet-sources.trash') }}">Corbeille</a> 

<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small " {{--uk-text-small responsive --}}>	
	<thead>
            <tr>
			<th>{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></th>
			<th>{{ ('Publiée') }}<i class="fas fa-sort uk-margin-left"></th>
			<th>{{ ('Modifier') }}</th>
			<th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}<i class="fas fa-sort uk-margin-left"></th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($sources as $source)
		<tr>
			<td><a href="{{ route('billet-sources.edit',['source'=>$source]) }}" > {{ucfirst($source->title) }}</a></td>
			<td> {{ $source->published }}</td>
			<td> <a href="{{ route('billet-sources.edit',['source'=>$source]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
			<td> <a href="{{ route('billet-sources.put-in-trash',['source'=>$source]) }}" ><span class="uk-text-success">Mettre en corbeille</span></a>

			</td>
			<td>{{ $source->id }}</td>
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