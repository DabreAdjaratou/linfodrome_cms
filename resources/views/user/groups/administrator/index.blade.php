@extends('layouts.administrator.master')
@section('title', 'Groups list')
@section('css')
<link href="{{ asset('css/jquery.treetable.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@parent
@section ('pageTitle')<h3>{{ ('Liste des groupes') }}</h3> @endsection 
<a href="{{ route('user-groups.create') }}">Nouveau</a> 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-small" >	
    <thead>
       <tr>
        <th>{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></th>
        <th>{{ ('Modifier') }}</th>
        <th>{{ ('Supprimer') }}</th>
        <th>{{ ('id') }}<i class="fas fa-sort uk-margin-left"></th>
    </tr>
</thead>
<tbody>

    @foreach($groups as $group)
    @if($group->parent_id==0)
   <tr data-tt-id="{{ $group->id }}">

    <td>{{ ucfirst($group->title) }}</td>
    <td> <a href="{{ route('user-groups.edit',['group'=>$group]) }}" ><span class="uk-text-success">Modifier</span></a>
            </td>
            <td> <form action="{{ route('user-groups.destroy',['group'=>$group]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer ce groupe?')">
                @csrf
                @method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
            </form> 
            </td>
    <td> {{$group->id }}</td> </tr>

    @if(count($group->getChildren))

    @include('user.groups.administrator.groupChild',['children' => $group->getChildren,'view'=>$view])

    @endif
    @else
 <tr data-tt-id="{{ $group->id }}" data-tt-parent-id="{{ $group->parent_id }}">

    <td>{{ ucfirst($group->title) }}</td>
    <td> <a href="{{ route('user-groups.edit',['group'=>$group]) }}" ><span class="uk-text-success">Modifier</span></a>
            </td>
            <td> <form action="{{ route('user-groups.destroy',['group'=>$group]) }}" method="POST" id="deleteForm" onsubmit="return confirm('Êtes vous sûre de bien vouloir supprimer ce groupe?')">
                @csrf
                @method('delete')
<button class="uk-button uk-button-link"><span class="uk-text-danger">Supprimer</span></button>
            </form> 
            </td>
    <td> {{$group->id }}</td> </tr>

    @if(count($group->getChildren))

    @include('user.groups.administrator.groupChild',['children' => $group->getChildren,'view'=>$view])

    @endif
    @endif

    @endforeach                    

</tbody>
<tfoot>
</tfoot>

</table>

@section('sidebar')
@component('layouts.administrator.user-sidebar') @endcomponent 
@endsection

@section('js')
<script src="{{ asset('js/jquery.treetable.js')}}""></script>
<script>

$(document).ready(function() {
$("#dataTable").treetable();
    
     }); 
</script>

@endsection
@endsection
