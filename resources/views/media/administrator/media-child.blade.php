  <ul>
    <li class="folder">
    	<span id="{{ str_replace('/', '@',$directory)}}"> {{ str_limit(basename($directory),15) }}</span>
   @if(Storage::directories($directory))
@php 
$subDirectories=Storage::directories($directory);
@endphp
@foreach ($subDirectories as $s)
     @include('media.administrator.media-child',['directory'=>$s])
@endforeach
   @endif

   @if(Storage::files($directory))
@php 
$subFiles=Storage::files($directory);
@endphp
@foreach ($subFiles as $sf)
<ul><li data-jstree='{"icon":"glyphicon glyphicon-leaf"}'><span id="{{ str_replace('/', '@',$sf)}}">{{ str_limit(basename($sf),15)}}</span></li></ul>
@endforeach
   @endif
 </li>
</ul>

