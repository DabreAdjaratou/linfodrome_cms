  <div>
    <table id="dataTable" class="uk-table-hover uk-table-striped" > 
     <thead>
      <tr>
       <th id='title' class="tableSort">{{ ('Titre') }} <i class="fas fa-sort"></i></th>
       <th id="featured" class="tableSort">{{ ('A la une') }}<i class="fas fa-sort"></i></i></th>
       <th id="published" class="tableSort">{{ ('Publiée') }}<i class="fas fa-sort"></i></i></th>
       <th>{{ ('Category') }}</th>
       <th>{{ ('Auteur') }}</th>
       <th id="created_at" class="tableSort">{{ ('créé le') }}<i class="fas fa-sort"></i></i></th>
       <th >{{ ('Dernière modification') }}</i></th>
       <th>{{ ('Modifié le') }}</i></th>
       <th id="views" class="tableSort">{{ ('Nbre de vue') }}<i class="fas fa-sort"></i></i></th>
       <th>{{ ('Image') }}</th>
       <th>{{ ('brouillon') }}</th>
       <th>{{ ('Corbeille') }}</th>
       <th>{{ ('id') }}</th>                       
     </tr>
   </thead>
   <tbody>
    @foreach($articles as $article)
    <tr class="uk-text-small">
      <td class="uk-table-expand"><a href="{{ route('articles.edit',['article'=>$article]) }}" > {{ $article->title }}</a></td>
      <td> {{ $article->featured }}</td>
      <td> {{ $article->published }}</td>
      <td class="uk-table-expand">{{ $article->getCategory->title }}</td>
      <td class="uk-table-expand">{{ $article->getAuthor->name }} </td>
      <td class="uk-table-expand"> {{ date("d/m/Y H:i:s", strtotime( $article->created_at)) }}</td>
      <td class="uk-table-expand">{{$article->getRevision->last()['getModifier']['name']}} </td>
      <td class="uk-table-expand">@if($article->getRevision->last()['revised_at']){{ date("d/m/Y H:i:s", strtotime($article->getRevision->last()['revised_at']))}} @endif  </td>
      <td> {{ $article->views }}</td>
      <td> {{ $article->image }}</td>
          <td> <a href="{{ route('articles.put-in-draft',['article'=>$article]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a>
          </td>
          <td> <a href="{{ route('articles.put-in-trash',['article'=>$article]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a>
          </td>
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