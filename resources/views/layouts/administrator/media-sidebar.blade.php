@php

$dir = base_path('storage\app\images');
//  si le dossier pointe existe
if (is_dir($dir)) {

   // si il contient quelque chose
   if ($dh = opendir($dir)) {

       // boucler tant que quelque chose est trouve
       while (($file = readdir($dh)) !== false) {

           // affiche le nom et le type si ce n'est pas un element du systeme
           if( $file != '.' && $file != '..') {
              	if(is_dir(base_path('storage\app\images'.'\\'.$file))){
              		echo "<div id='".$file."' class='folder'><span uk-icon='icon: folder; ratio: 1.5'></span>$file</div>";
           	}else {
           		echo "<div><span id='image' uk-icon='image'></span>$file</div>";
           	}
           }
        
       }
       // on ferme la connection
       closedir($dh);
   }
}
// echo str_replace('\\', '/', $folder);
@endphp

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".folder").click(function(event){
      var media=$(this).attr('id');
              $("#txtHint").load("{{route('media-child',['media'=>'folder'])}}".replace('folder',media));
    });
});
</script>
