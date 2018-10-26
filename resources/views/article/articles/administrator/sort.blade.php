

@extends('layouts.administrator.master')
@section('title', 'Articles list')
@section('css')
@endsection
@section('content')
@section ('pageTitle')
@parent
<div id='tableContainer'>
<h3>  {{ ('Liste des articles') }}</h3> @endsection
<a href="{{ route('articles.create') }}">Nouveau</a> 
{{-- <input type="text" name="title" id="title"> --}}
<label> Affiché </label>
<select id=entries> 
  @for($i=0; $i<sizeof($entries);$i++)
<option value="{{ $entries[$i] }}" @if($entries[$i] == $articles->perPage())  selected @endif>{{ $entries[$i] }}</option>
  @endfor
</select> <label> lignes</label>
<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-table-small uk-table-justify uk-text-small responsive" >   
    <thead>
            <tr>
            <th>{{ ('Titre') }} <i class="fas fa-sort" id='title'></i></th>
            <th>{{ ('A la une') }}<i class="fas fa-sort" id='featured'></i></th>
            <th>{{ ('Publiée') }}<i class="fas fa-sort" id='published'></i></th>
            <th>{{ ('Category') }}<i class="fas fa-sort" id='category'></i></th>
            <th>{{ ('Auteur') }}<i class="fas fa-sort" id='auteur'></i></th>
            <th>{{ ('créé le') }}<i class="fas fa-sort" id='created_at'></i></th>
            <th>{{ ('Dernière modification') }}<i class="fas fa-sort" id='updated_by'></i></th>
            <th>{{ ('Modifié le') }}<i class="fas fa-sort" id='updated_at'></i></th>
            <th>{{ ('Nbre de vue') }}<i class="fas fa-sort" id='views'></i></th>
            <th>{{ ('Image') }}</th>
            <th>{{ ('Modifier') }}</th>
      <th>{{ ('brouillon') }}</th>
            <th>{{ ('Corbeille') }}</th>
            <th>{{ ('id') }}</th>                       
        </tr>
    </thead>
    <tbody>
        {{ dd($articles) }}
        @foreach($articles as $article)
        <tr class="uk-text-small">
            {{-- <td ><input type="checkbox" name="" class="uk-checkbox"></td> --}}
            <td class="uk-table-expand"> {{ $article->title }}</td>
            <td> {{ $article->featured }}</td>
            <td> {{ $article->published }}</td>
            <td class="uk-table-expand"> {{ $article->getCategory->title }}</td>
            <td class="uk-table-expand"> {{ $article->getAuthor->name }}</td>
           <td class="uk-table-expand"> {{ $article->created_at }}</td>
            <td class="uk-table-expand">{{$article->getRevision->last()['getModifier']['name']}} </td>
            <td class="uk-table-expand">{{$article->getRevision->last()['revised_at']}}  </td>
            <td> {{ $article->views }}</td>
            <td> {{ $article->image }}</td>
            <td> <a href="{{ route('article-archives.edit',['article'=>$article]) }}" ><span class="uk-text-success">Modifier</span></a>
            </td>
                        <td> <a href="{{ route('articles.put-in-draft',['article'=>$article]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a>
            </td>
             <td> <a href="{{ route('article-archives.put-in-trash',['article'=>$article]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>
            </td>
            <td>{{ $article->id }}</td>
                </tr>
        @endforeach
   </tbody>
    <tfoot>
    </tfoot>

</table>
</div>
<p>  {{ $tableInfo}} </p>
{{ $articles->links() }}
<div id="div1"></div>
@section('sidebar')
 @component('layouts.administrator.article-sidebar') @endcomponent 
@push('js')
<script type="text/javascript">
$(document).ready(function() {
    
 var table=$('#dataTable').DataTable({
  paging:false,
  searching:false,
  ordering:false,
  info:false
 });

$('#entries').on('change',function(){
   
            $("#tableContainer").load("{{route('articles.list',['pageLength'=>'length'])}}".replace('length',this.value));
       
});

$('.fa-sort').on('click',function(){
            $("#tableContainer").load("{{route('articles.sort',['sort'=>'sortValue'])}}".replace('length',this.id));
       
});
 }); 
</script>
@endpush

@endsection

@section('js')

@endsection

@endsection
