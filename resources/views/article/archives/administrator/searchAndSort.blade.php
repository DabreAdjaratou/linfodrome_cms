  <div>
    <table id="dataTable" class="uk-table tuk-table-responsive uk-table-hover uk-table-striped uk-text-small" > 
     <thead>
      <tr>
       <th id='title' class="tableSort">{{ ('Titre') }} <i class="fas fa-sort uk-margin-left"></i></th>
       <th id="featured" class="tableSort">{{ ('A la une') }}<i class="fas fa-sort uk-margin-left"></i></th>
       <th id="published" class="tableSort">{{ ('Publiée') }}<i class="fas fa-sort uk-margin-left"></i></th>
      <th id="category" class="tableSort">{{ ('Category') }}<i class="fas fa-sort uk-margin-left"></i></th>
       <th id="author" class="tableSort">{{ ('Auteur') }}<i class="fas fa-sort uk-margin-left"></i></th>
       <th id="created_at" class="tableSort">{{ ('créé le') }}<i class="fas fa-sort uk-margin-left"></i></th>
       <th >{{ ('Revisions') }}</th>
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
      <td> <a href="{{ route('article-revisions.show',['revision'=>$article->id]) }}" >{{ 'revisions'}}</a></td>
      <td> {{ $article->views }}</td>
      <td> {{ $article->image }}</td>

      {!! str_replace('articleId',$article->id, $actions)!!}
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