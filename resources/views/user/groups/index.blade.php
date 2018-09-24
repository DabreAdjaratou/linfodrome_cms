@extends('layouts.administrator.master')
@section('title', 'Groups list')
@section('css')
@endsection
@section('content')
@parent
@section ('pageTitle')<h3>{{ ('Liste des groupes') }}</h3> @endsection 
<a href="{{ route('user-groups.create') }}">Nouveau</a> 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-divider uk-table-small" {{--uk-text-small responsive --}} >	
    <thead>
       <tr>
        <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
        <th>{{ ('Titre') }}</th>
        <th>{{ ('id') }}</th>
    </tr>
</thead>
<tbody>

   <tr>
    @foreach($groups as $group)

    <td><input type="checkbox" name="groups[]" value="{{$group->id}}" class="uk-checkbox"></td>
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

    @include('user.groups.groupChild',['children' => $group->getChildren,'view'=>$view])

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
@endsection
@endsection
