@extends('layouts.administrator.master')
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
              		$folder=$file;
           		echo "<div><span id='media' uk-icon='icon: folder; ratio: 1.5'></span>$file</div>";
           	}else {
           		echo "<div><span id='media' uk-icon='image'></span>$file</div>";
           	}
           }
        
       }
       // on ferme la connection
       closedir($dh);
   }
}
// echo str_replace('\\', '/', $folder);
@endphp
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script type="text/javascript">
  $('#media').click(function subDirectories(){
  var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "{{route('media-child',['media'=>$folder]) }}" , true);
        xmlhttp.send();
  })

</script>