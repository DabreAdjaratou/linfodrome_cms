@extends('layouts.administrator.master')
@section('title', 'Actions list')
@section('css')
@endsection
@section('content')
@parent
@section ('pageTitle')<h3>  {{ ('Liste des actions') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-striped uk-table-hover uk-table-small uk-text-small responsive">	
<thead>
	<tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
		<th>{{ ('Titre') }}</th>
		<th>{{ (' Display name') }}</th>
	<th>id</th>

	</tr>
	

</thead>
<tbody>

@foreach($actions as $action)


	<tr>
            <td><input type="checkbox" name="" class="uk-checkbox"></td>
		<td>{{ ucfirst($action->title) }}</td>
		<td>{{ ucfirst($action->display_name )}}</td>
		<td>{{ $action->id }}</td>

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
