@php 
$ar=explode('/', url()->current());
$f=$ar[6];

$dir = base_path('storage\app\images'.'\\'.$f);
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
           		echo "<span id='media'>$file<br />\n</span><div id='txtHint'></div>";
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
@endphp