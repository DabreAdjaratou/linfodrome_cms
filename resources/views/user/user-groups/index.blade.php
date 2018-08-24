@extends('layouts.administrator.master')
@section('title', 'Group list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')<h3>Liste des groupes</h3> @endsection 
<table class="uk-table uk-table-striped uk-table-small">	
<thead>
	<tr>
		<th>Titre</th>
		<th>id</th>

	</tr>
	

</thead>
<tbody>

@foreach($groups as $group)
@isset($group->parent)
@php


@endphp
<tr>
		<td>{{ $group->parent['title'] }}</td>

      	<td>{{ $group->parent['id'] }}</td>
</tr>
<tr>
<td>{{ '------'.$group->title }}</td>
	
</tr>
@endisset





@endforeach
</tbody>

<tfoot>
	


</tfoot>

</table>

{{$groups->links()}}

@endsection
