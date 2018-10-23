@extends('layouts.administrator.master')
@section('title', 'Billets draft')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<h3>  {{ ('Liste des billets au brouillon') }}</h3> @endsection 
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-text-small responsive uk-table-justify responsive" >	
	<thead>
            <tr>
            <th><input type="checkbox" name="checkedAll" class="uk-checkbox"></th>
			<th>{{ ('Titre') }}</th>
			<th>{{ ('A la une') }}</th>
			<th>{{ ('Publié') }}</th>
			<th>{{ ('Category') }}</th>
			<th>{{ ('Auteur') }}</th>
			<th>{{ ('créé le') }}</th>
			<th>{{ ('Dernière modification') }}</th>
			<th>{{ ('Modifié le') }}</th>
			<th>{{ ('Nbre de vue') }}</th>
			<th>{{ ('Image') }}</th>
                        <th>{{ ('Modifier') }}</th>
                         <th>{{ ('Corbeille') }}</th>
			<th>{{ ('id') }}</th>                       
		</tr>
	</thead>
	<tbody>
		@foreach($archives as $billet)
		<tr class="uk-text-small">
			<td ><input type="checkbox" name="" class="uk-checkbox"></td>
			<td class="uk-table-expand"> {{ $billet->title }}</td>
			<td> {{ $billet->featured }}</td>
			<td> {{ $billet->published }}</td>
			<td class="uk-table-expand"> {{ $billet->getCategory->title }}</td>
			<td class="uk-table-expand"> {{ $billet->getAuthor->name }}</td>
			<td class="uk-table-expand"> {{ $billet->created_at }}</td>
			<td class="uk-table-expand">{{$billet->getRevision->last()['getModifier']['name']}} </td>
			<td class="uk-table-expand">{{$billet->getRevision->last()['revised_at']}}  </td>
			<td> {{ $billet->views }}</td>
			<td> {{ $billet->image }}</td>
                        <td> <a href="{{ route('billet-archives.edit',['billet'=>$billet]) }}" ><span class="uk-text-success">Modifier</span></a>

			</td>
                        <td> <a href="{{ route('billet-archives.put-in-trash',['billet'=>$billet]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>

			</td>
			<td>{{ $billet->id }}</td>
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
<script type="text/javascript" src="{{asset('js/custom-datatable.js')}}" ></script>
@endsection
@endsection

