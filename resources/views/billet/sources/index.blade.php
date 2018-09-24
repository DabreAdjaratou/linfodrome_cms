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
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th> {{ ('Publiée') }}</th>
			<th>{{ ('Modifier') }}</th>
			<th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($sources as $source)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
			<td> {{ucfirst($source->title) }}</td>
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

@endsection

@endsection