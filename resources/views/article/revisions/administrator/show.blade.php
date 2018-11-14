@foreach($article as $article)
<div>{{ $article->title }}</div>
<div>{{ $article->getCategory->title }}</div>
<div>{{ $article->getAuthor->name }}</div>
<div>{{ $article->created_at }}</div>
<div>@foreach($article->getRevision as $revision)
	<div>{{ $revision }}</div>
	@endforeach
@endforeach
