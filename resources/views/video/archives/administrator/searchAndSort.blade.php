<div>
	<table id="dataTable" class="uk-table uk-table-hover uk-table-striped uk-text-small">	
		<thead>
			<tr>
				<th id="title" class="tableSort">{{ ('Titre') }}<i class="fas fa-sort uk-margin-left"></th>
					<th id="category" class="tableSort">{{ ('Categorie') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th id="featured" class="tableSort">{{ ('A la Une') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th id="published" class="tableSort">{{ ('Publiée') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th id="journaliste" class="tableSort">{{ ('Journaliste') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th id="camera_operator" class="tableSort">{{ ('Cameraman') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th id="video_editor" class="tableSort">{{ ('Monteur') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th id="created_at" class="tableSort">{{ ('crée lé') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th id="start_publication_at" class="tableSort">{{ ('Debut publication') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th id="stop_publication_at" class="tableSort">{{ ('fin publication') }}<i class="fas fa-sort uk-margin-left"></i></th>
					<th >{{ ('Revisions') }}</i></th>
					<th id="views" class="tableSort">{{ ('Nbre de vue') }}<i class="fas fa-sort uk-margin-left"></i></th>
					{!! $actionTitles !!}
					<th id="id" class="tableSort">{{ ('id') }}<i class="fas fa-sort uk-margin-left"></i></th>

				</tr>
			</thead>
			<tbody>		
				@foreach($items as $video)		
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
      <td> <a href="{{ route('video-revisions.show',['revision'=>$video->id]) }}" >{{ 'Revisions'}}</a></td>
					
					<td> {{$video->views}}</td>
				                        {!! str_replace('videoId',$video->id, $actions)!!}

                                        <td>{{ $video->id }}</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
		</tfoot>
	</table>
</div>
{{ $tableInfo}}
{{ $items->links() }}