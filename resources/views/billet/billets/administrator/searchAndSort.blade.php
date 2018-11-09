<div>
<table id="dataTable" class=" uk-table uk-table-hover uk-table-striped uk-text-small" > 
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
            <th>{{ ('brouillon') }}</th>
            <th>{{ ('Corbeille') }}</th>
            <th id="id" class="tableSort">{{ ('id') }}<i class="fas fa-sort uk-margin-left"></i></th>                       
        </tr>
    </thead>
    <tbody>
        @foreach($billets as $billet)
        <tr>
            <td>  <a href="{{ route('billet-archives.edit',['billet'=>$billet]) }}" >{{ $billet->title }}</a></td>
            <td> {{ $billet->featured }}</td>
            <td> {{ $billet->published }}</td>
            <td> {{ $billet->getCategory->title }}</td>
            <td>{{ $billet->getAuthor->name }} </td>
            <td> {{ $billet->created_at }}</td>
            <td>{{$billet->getRevision->last()['getModifier']['name']}} </td>
            <td>{{$billet->getRevision->last()['revised_at']}}  </td>
            <td> {{ $billet->views }}</td>
            <td> {{ $billet->image }}</td>
            <td> <a href="{{ route('billets.put-in-draft',['billet'=>$billet]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a>
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
    </div>
 {{ $tableInfo}}
{{ $billets->links() }}