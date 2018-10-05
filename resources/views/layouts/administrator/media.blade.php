{{-- 	<link rel="stylesheet" type="text/css" href="{{asset('css/uikit.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
	<script src="{{asset('js/uikit-icons.min.js')}}"></script>

<h1> media</h1>
<button id="transferer">Transferer</button> <button id="nouveauDossier">creer un dossier</button> <button id="supprimer">supprimer</button>
<form> 
	<span uk-icon="folder"> </span>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

{{-- <script type="text/javascript">
	
	$("#transferer").click(function(){
		var browse='<input type="file"></input>';
   $("form").append(browse); 
}); 

	$("#nouveauDossier").click(function(){
    alert("Nouveau dossier.");
}); 

	$("#supprimer").click(function(){
    alert("supprimer");
}); 

</script> --}}
{{-- @php

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
           		echo "<span id='media'>◙ $file<br />\n</span><div id='txtHint'></div>";
           		array_diff(scandir(base_path('storage\app\images'.'\\'.$file)), array('..', '.'));
           	}else {
           		echo "$file<br />\n";
           	}
           }
        
       }
       // on ferme la connection
       closedir($dh);
   }
}
// echo str_replace('\\', '/', $folder);
@endphp --}}
{{-- <script type="text/javascript">
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

</script> --}}

  