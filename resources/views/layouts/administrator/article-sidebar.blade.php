<ul>
	<li><a href="{{ route('articles.index') }}">{{ ('Articles') }}</a></li>
	<li><a href="{{ route('article-archives.index') }}">{{ ('Archives') }}</a></li>
	<li><a href="{{ route('article-categories.index') }}">{{ ('Categories d\'articles') }}</a></li>   
	<li><a href="{{ route('article-sources.index') }}">{{ ('Sources') }} </a></li>
	<li><a href="{{ route('article-revisions.index') }}">{{ ('Revisions des articles') }} </a></li>
	<li><a href="{{ route('article-archives.trash') }}">{{ ('Articles en corbeille') }} </a></li>
	<li><a href="{{ route('article-archives.draft') }}">{{ ('Brouillons') }} </a></li>
</ul>