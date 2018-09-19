@extends('layouts.administrator.master')
@section('title', 'Permissions list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des Permissions') }}</h3> @endsection 
<div class="uk-margin ">	
	<a href="{{ route('permissions.create') }}">Nouveau</a>
</div>
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small " {{--uk-text-small responsive --}}>	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('Pulieé') }}</th>
			<th> {{ ('Modifier') }}</th>
			<th> {{ ('Supprimer') }}</th>
			<th>{{ ('id') }}</th>

                       
		</tr>
	</thead>
	<tbody>
	
@foreach($permissions as $permission)

@foreach ($permission as $p)

{{ ($p->getAccessLevel->title) }}
 @endforeach 

{{-- @for($i=0; $i<count($permission); $i++)
<tr> 
@if($i==0)
<tr><td><a href="{{ route('permissions.edit',['permission'=>$permission[$i]->getAccessLevel->id]) }}">{{ $permission[$i]->getAccessLevel->title }}</a></td>
<td>{{ $permission[$i]->getResource->title }}</td>
<td>{{ $permission[$i]->getAction->title}} </td>
@else
@php $i2=$i - 1 ;@endphp

@if ($permission[$i]->getResource->title==$permission[$i2]->getResource->title) 
	<td>{{ $permission[$i]->getAction->title}}</td>
@else
<td>{{ $permission[$i]->getResource->title}}</td>
<td>{{ $permission[$i]->getAction->title }} </td> --}}


{{-- @endif


@endif
</tr>
@endfor --}}

@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
@section('sidebar')

@endsection

@section('js')

@endsection

@endsection




