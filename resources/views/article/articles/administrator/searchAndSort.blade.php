  <div>
    <table id="dataTable" class="uk-table tuk-table-responsive uk-table-hover uk-table-striped uk-text-small" > 
     <thead>
      <tr>
       <th id='title' class="tableSort">{{ ('Titre') }} <i class="fas fa-sort uk-margin-left"></i></th>
       <th id="featured" class="tableSort">{{ ('A la une') }}<i class="fas fa-sort uk-margin-left"></i></th>
       <th id="published" class="tableSort">{{ ('Publiée') }}<i class="fas fa-sort uk-margin-left"></i></th>
       <th>{{ ('Category') }}</th>
       <th>{{ ('Auteur') }}</th>
       <th id="created_at" class="tableSort">{{ ('créé le') }}<i class="fas fa-sort uk-margin-left"></i></th>
       <th >{{ ('Dernière modification') }}</i></th>
       <th>{{ ('Modifié le') }}</i></th>
       <th id="views" class="tableSort">{{ ('Nbre de vue') }}<i class="fas fa-sort uk-margin-left"></i></th>
       <th>{{ ('Image') }}</th>
       {!! $actionTitles !!}
       <th  id='id' class="tableSort">{{ ('id') }}<i class="fas fa-sort uk-margin-left"></i></th>                       
     </tr>
   </thead>
   <tbody>
    @foreach($articles as $article)
    <tr>
      <td><a href="{{ route('articles.edit',['article'=>$article]) }}" > {{ $article->title }}</a></td>
      <td> {{ $article->featured }}</td>
      <td> {{ $article->published }}</td>
      <td>{{ $article->getCategory->title }}</td>
      <td>{{ $article->getAuthor->name }} </td>
      <td> {{ date("d/m/Y H:i:s", strtotime( $article->created_at)) }}</td>
      <td>{{$article->getRevision->last()['getModifier']['name']}} </td>
      <td>@if($article->getRevision->last()['revised_at']){{ date("d/m/Y H:i:s", strtotime($article->getRevision->last()['revised_at']))}} @endif  </td>
      <td> {{ $article->views }}</td>
      <td> {{ $article->image }}</td>

      {!!  str_replace('articleId',$article->id, $actions)!!}
      <td>{{ $article->id }}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
  </tfoot>

</table>
</div>
{{ $tableInfo}}
{{ $articles->links() }}