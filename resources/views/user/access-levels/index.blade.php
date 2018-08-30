@extends('layouts.administrator.master')
@section('title', 'Access levels list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{{ ('Liste des niveaux d\'accès') }}}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small">	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Groupes utilisateurs') }}</th>
			<th>{{ ('Id') }}</th>
                       
		</tr>
	</thead>
	<tbody>
		@foreach($accessLevels as $access)
		<tr>
			<td><input type="checkbox" name="" class="uk-checkbox"></td>
			<td> <a href="">{{ ucfirst($access->title) }}</a></td>
			<td>{{ $access->groups }}</td>
			<td>{{ $access->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')
 @component('layouts.administrator.user-sidebar') @endcomponent 
@endsection

@section('js')

@endsection

@endsection
