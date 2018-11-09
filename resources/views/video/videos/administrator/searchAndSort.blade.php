<div>
<table id="dataTable" class=" uk-table uk-table-hover uk-table-striped uk-text-small">	
	<thead>
            <tr>
			<th id="title" class="tableSort">{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></th>
			<th id="category_id" class="tableSort">{{ ('Categorie') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th id="featured" class="tableSort">{{ ('A la Une') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th id="published" class="tableSort">{{ ('Publiée') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('Journaliste') }}</th>
			<th>{{ ('Cameraman') }}</th>
			<th>{{ ('Monteur') }}</th>
			<th id="created_at" class="tableSort">{{ ('crée lé') }}<i class="fas fa-sort uk-margin-left"></i></th>
			<th>{{ ('Debut publication') }}</th>
			<th>{{ ('fin publication') }}</th>
			<th id="views" class="tableSort">{{ ('Nbre de vue') }}<i class="fas fa-sort uk-margin-left"></i></th>
                        <th>{{ ('Brouillon') }}</th>
                        <th>{{ ('Corbeille') }}</th>
			<th id="id" class="tableSort">{{ ('id') }}<i class="fas fa-sort uk-margin-left"></i></th>
                       
		</tr>
	</thead>
	<tbody>		
		@foreach($videos as $video)		
		<tr>
            <td><a href="{{ route('videos.edit',['video'=>$video]) }}" > {{ ucfirst($video->title) }}</a></td>
			<td> {{$video->getCategory->title}}</td>
			<td> {{ $video->featured }}</td>
			<td> {{ $video->published }}</td>
			<td> {{ucwords($video->getAuthor->name)}}</td>
			<td> {{ucwords($video->getCameraman->name)}}</td>
			<td> {{ucwords($video->getEditor->name)}}  </td>
			<td>{{$video->created_at}}</td>
			<td>{{ $video->start_publication_at}} </td>
			<td> {{$video->stop_publication_at}}</td>
			<td> {{$video->views}}</td>
			</td><td> <a href="{{ route('videos.put-in-draft',['video'=>$video]) }}" ><span class="uk-text-success">Mettre au brouillon</span></a></td>
      <td> <a href="{{ route('videos.put-in-trash',['video'=>$video]) }}" ><span class="uk-text-danger">Mettre en corbeille</span></a></td>
			<td>{{ $video->id }}</td>
                </tr>
		@endforeach
	</tbody>
	<tfoot>
	</tfoot>
</table>
  </div>
{{ $tableInfo}}
{{ $videos->links() }}