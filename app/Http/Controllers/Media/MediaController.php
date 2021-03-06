<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
	/*
	  * Protecting routes
     */
	public function __construct()
	{
		$this->middleware(['auth','activeUser']);
	}
/**
*diplaying list of file and directories from images folder
*@param
*@return Illuminate\Http\Response;
**/
public function index(){
	if(isset($_GET['directory'])){
		$directory=$_GET['directory'];
		$directories=Storage::directories($directory);
		$files=Storage::files($directory);
		$mediaPath = $this->rootLinks($directory) ;
		$path=$directory;
	}else{
		$directories=Storage::directories('public/images');
		$files=Storage::files('public/images');
		$mediaPath =$this->rootLinks('public/images');
		$path=('public/images');
	}
	return view('media.administrator.index',compact('directories','files','mediaPath','path'));
}

/**
* open the specified resource
*@param  media $media
*@return Illuminate\Http\Response
**/
public function open($media){
	$mediaPath=str_replace('@','/',$media);
	$directories=Storage::directories($mediaPath);
	$files=Storage::files($mediaPath);
	$path= $mediaPath;
	$mediaPath=$this->rootLinks($mediaPath);
	return view('media.administrator.open',compact('directories','files','mediaPath','path'));
}
	/**
*create a new folder
*@param Illuminate\Http\Request $request
*@return Illuminate\Http\ Response
**/
public function createFolder(Request $request){
	$validatedData = $request->validate([
		'folderName' => 'required|string',
	]);
	$folder= str_replace('/', '\\',  storage_path('app/'.$request->folderPath.'/'.$request->folderName));

	if(is_dir($folder))
	{
		session()->flash('message.type', 'warning');
		session()->flash('message.content', 'Le dossier <strong>'.$request->folderName.'</strong> que vous essayé de creer existe dejà dans <strong>'.$request->folderPath.'</strong>');

	}
	else {
		Storage::makeDirectory($request->folderPath.'/'.$request->folderName);
		session()->flash('message.type', 'success');
		session()->flash('message.content', 'Le dossier <strong>'.$request->folderName.'</strong> a été crée dans <strong>'.$request->folderPath.'</strong>');

	}
	return redirect()->route('media',['directory'=>$request->folderPath]);
}

/**
*upload an image
*@param Illuminate\http\Request $request
*@return Illuminate\http\Response
**/
public function upload(Request $request){
	$validatedData = $request->validate([
		'uploadedFile'=>'image',
	]);

	$filename=strtolower($request->uploadedFile->getClientOriginalName());
	$fileExtension= '.'.$request->uploadedFile->extension();
	if($fileExtension=='.jpeg'){
		$fileExtension='.jpg';
	}

	$filename=str_slug(basename($filename,$fileExtension),'-').$fileExtension;
	$path= $request->path;
	$exists = Storage::disk('local')->exists($path.'/'.$filename);
	if($exists){
		session()->flash('message.type', 'warning');
		session()->flash('message.content', 'Le fichier <strong>'.$filename.'</strong> existe dejà dans : <strong>'. $path.'</strong>');
	}else{
		$request->uploadedFile->storeAs($path, $filename);
		session()->flash('message.type', 'success');
		session()->flash('message.content', 'Le fichier <strong>'.$filename.'</strong> a bien été Transferer dans : <strong>'. $path.'</strong>');
	}
	return redirect()->route('media',['directory'=>$path]);
}


/**
*rename a resource
*@param Illuminate\http\Request $request
*@return Illuminate\http\Response
**/
public function rename(Request $request){
	$oldName=str_replace('@','/',$request->oldName);
	$newName=$request->newName;
	$path=$request->folderPath;
	$folder= str_replace('/', '\\',  storage_path('app/'.$oldName));
	$exists = Storage::disk('local')->exists(str_replace('/'.class_basename($oldName),'',$oldName).'/'.$newName);
	if($exists){
		session()->flash('message.type', 'danger');
		session()->flash('message.content', 'Impossible de renommer, ce fichier existe dejà!');
	}else{
		Storage::move($oldName, str_replace('/'.class_basename($oldName),'',$oldName).'/'.$newName);
		session()->flash('message.type', 'success');
		session()->flash('message.content', 'Fichier renommé !');
	}
	return redirect()->route('media',['directory'=>$path]);
}
/**
*
*@param
*@return
**/
	// public function download($media){
	// 	$media=str_replace('@','/',$media);

	// 	return Storage::download($media, class_basename($media),['Content-Type: application/pdf']);
	// }

	/**
*delete a specified resource from the storage
*@param media $media
*@return alert message
**/
public function delete($media){
	$media=str_replace('@','/',$media);

	$folder= str_replace('/', '\\',  storage_path('app/'.$media));
	str_replace('/'.class_basename($media),'',$media);

	if(is_dir($folder)){
		$directories=Storage::directories($media);
		$files=Storage::files($media);
		if($directories || $files){
			$alert= '<div class="uk-alert uk-alert-danger">Le dossier <strong>'.class_basename($media).' </strong> ne peut etre supprimé car il contient un ou plisieurs élement </div>';
			return $alert;
		}else{
			Storage::deleteDirectory($media);
			$alert= '<div class="uk-alert uk-alert-success">Le dossier <strong>'.class_basename($media).' </strong> a été supprimé</div>';
			return $alert;
		}
	}else{
		Storage::delete($media);

		$alert= '<div class="uk-alert uk-alert-success">Le fichier <strong>'.class_basename($media).'</strong> a été supprimé</div>';
		return $alert;
	}
}

	/**
* get properties of the specified resource
*@param media $media
*@return json response
**/
public function getProperties($media){
	$path=str_replace('@','/',$media);
	$name=basename($path);
	$lastModified = date('d/m/Y H:i:s', Storage::lastModified($path));
	$folder= str_replace('/', '\\',  storage_path('app/'.$path));
	$dimension='';
	$type='';
	if(is_dir($folder)){
		$size= $this->convertToReadableSize($this->folderSize($folder));
	}else{
		$size = $this->convertToReadableSize(Storage::size($path));
		$dimension=(getimagesize (storage_path('app/'.$path)))[3];
		$type=(getimagesize (storage_path('app/'.$path)))['mime'];

	}

	return '{"path":"'.$path.'","name":"'.$name.'","lastModified":"'.$lastModified.'","size":"'.$size.'","type":"'.$type.'","dimension":"'.addslashes($dimension).'"}';
}

/**
*convert a size to a readable size
*@param int $size
*@return a readable size          
**/
function convertToReadableSize($size){
	$base = log($size) / log(1024);
	$suffix = array("", "Ko", "Mo", "Go", "To");
	$f_base = floor($base);
	return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}
/**
*get the size of a directory
*@param directory $dir
*@return size $size
**/
function folderSize($dir)
{
	$size = 0;
	foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
		$size += is_file($each) ? filesize($each) : $this->folderSize($each);
	}
	return $size;
}
		/**
*get links of different part of the root
*@param  a path $path
*@return
**/
function rootLinks($path){
	$id='';
	$path=explode('/',$path);
	for ($i=0 ; $i<sizeof($path); $i++) { 
		$id .= $path[$i].'@';
		if($i==0){
			$path[$i]='<span" id="'.$id.'">'.$path[$i].'</span>';
		}else{
			$path[$i]='<a class="folder" id="'.$id.'">'.$path[$i].'</a>';
		}
	}
	$pathWithLinks=implode('/', $path);
	return $pathWithLinks;
}

}
