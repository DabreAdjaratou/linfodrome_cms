 <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>jsTree test</title>
  <!-- 2 load the theme CSS file -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
</head>
<body>

	
  <!-- 3 setup a container element -->
  <div id="jstree">
    <!-- in this example the tree is populated from inline HTML -->
    <ul>
@foreach( $directories as $directory)
	<li>
	{{ basename($directory) }}
	@if(Storage::directories($directory))
@php 
$subDirectories=Storage::directories($directory);
@endphp
@foreach ($subDirectories as $s) 
	@if ( Storage::directories($s)) 
		 @include('media.administrator.media-child',['directory'=>$s])
	@else 
	@endif
@endforeach
	 @endif

	 	@if(Storage::files($directory))
	@php                    
$subfiles= Storage::files($directory);
foreach ($subfiles as $sf) {
echo '<ul><li><span style="color: red">'.basename($sf).'</span></li></ul>';
}
	@endphp
	 @endif
	{{--  <ul>
          <li id="{{ $directory }}">Child node 1</li>
          <li>Child node 2
           <ul>
          <li id="{{ $directory }}">Child node 2-1</li>
          <li>Child node 2-2</li>
        </ul>
    </li>
        </ul> --}}
        
    </li>
	@endforeach
@foreach( $files as $file)
      <li> <span style="color: red">{{ basename($file)}}</span> </li>
@endforeach
          </ul>
  </div>
 
  <!-- 4 include the jQuery library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
  <!-- 5 include the minified jstree source -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
  <script>
  $(function () {
    // 6 create an instance when the DOM is ready
    $('#jstree').jstree();
    // 7 bind to events triggered on the tree
    $('#jstree').on("changed.jstree", function (e, data) {
      console.log(data.selected);
    });
    // 8 interact with the tree - either way is OK
    // $('button').on('click', function () {
    // 	var directory=$(this).attr('id');
    //   $('#jstree').jstree(true).select_node(directory);
    //   $('#jstree').jstree('select_node', directory);
    //   $.jstree.reference('#jstree').select_node(directory);
    // });
  });
  </script>
</body>
</html>