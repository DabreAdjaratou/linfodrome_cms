 <!DOCTYPE html>
 <html>
 <head>
  <meta charset="utf-8">
  <title>jsTree test</title>
</head>
<body>

 {{-- setup a container element --}}
 <div id="jstree">
  {{-- in this case the tree is populated from inline HTML --}}
  <ul>
    @php
    $directories=Storage::directories('public/images');
    $files=Storage::files('public/images');
    @endphp
    @foreach( $directories as $directory)
    <li><span id="{{ str_replace('/', '@',$directory)}}">{{ str_limit(basename($directory),15) }}</span>
      @php 
      $subDirectories=Storage::directories($directory);
      @endphp
      @foreach ($subDirectories as $s) 
      @include('media.administrator.media-child',['directory'=>$s])
      @endforeach

      @php                    
      $subfiles= Storage::files($directory);
      @endphp
      @foreach ($subfiles as $sf) 
      <ul><li data-jstree='{"icon":"glyphicon glyphicon-leaf"}' class="uk-text-truncate">
        <span id="{{ str_replace('/', '@',$sf)}}">{{str_limit(basename($sf),15)}}</span></li></ul>
        @endforeach
      </li>
      @endforeach
      @foreach( $files as $file)
      <li data-jstree='{"icon":"glyphicon glyphicon-leaf"}' class="uk-text-truncate">
       <span id={{ str_replace('/', '@',$file)}}>{{ str_limit(basename($file),15)}}</span></li>
       @endforeach
     </ul>
   </div>
 </body>
 </html>