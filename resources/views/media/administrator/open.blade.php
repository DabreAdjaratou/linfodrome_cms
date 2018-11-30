<script >
	$('.racine').html('<div class="racine "> <i class="fa fa-folder-open uk-text-muted"> Racine : <?php echo $mediaPath; ?></i></div>');
	var mediaPath='<?php echo $mediaPath; ?>';
	$('.path').val(mediaPath);
</script>
@foreach($directories as $d)
<div class="folder media" id="{{str_replace('/', '@',$d) }}"> <img class="image-icon" src="{{asset('storage/images/icons/folder-icon.png') }}">
<div class="media-name"> {{str_limit(basename($d),8) }}</div>
</div>

@endforeach

@foreach($files as $f)

<div class="media files media-container" id="{{str_replace('/', '@',$f) }}"> <img class="image-icon" src="{{asset('storage/'.substr($f, 7)) }}" width="45px">
<div class="media-name">{{ str_limit(basename($f),8) }} </div>
</div>

@endforeach
<script src="{{ asset('js/media.js') }}"></script>
<script src="{{ asset('js/custom-menu-context.js') }}"></script>
