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

	public function index(){
		if(isset($_GET['directory'])){
			$directory=$_GET['directory'];
			$directories=Storage::directories($directory);
			$files=Storage::files($directory);
			$mediaPath = $directory ;
		}else{
			$directories=Storage::directories('public/images');
			$files=Storage::files('public/images');
			$mediaPath = 'public/images';
		}

		return view('media.administrator.index',compact('directories','files','mediaPath'));
	}

	public function open($media){
		$mediaPath=str_replace('@','/',$media);
		$directories=Storage::directories($mediaPath);
		$files=Storage::files($mediaPath);
		return view('media.administrator.open',compact('directories','files','mediaPath'));
	}
	public function createFolder(Request $request){
		$validatedData = $request->validate([
			'folderName' => 'required|string',
		]);
		$folder= str_replace('/', '\\',  storage_path('app/'.$request->folderPath.'/'.ucfirst($request->folderName)));

		if(is_dir($folder))
		{
			session()->flash('message.type', 'warning');
			session()->flash('message.content', 'Le dossier <strong>'.$request->folderName.'</strong> que vous essayé de creer existe dejà dans <strong>'.$request->folderPath.'</strong>');

		}
		else {
			Storage::makeDirectory($request->folderPath.'/'.ucfirst($request->folderName));
			session()->flash('message.type', 'success');
			session()->flash('message.content', 'Le dossier <strong>'.$request->folderName.'</strong> a été crée dans <strong>'.$request->folderPath.'</strong>');

		}
		return redirect()->route('media',['directory'=>$request->folderPath]);
	}

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


	public function cut($media){
	}
	public function rename(Request $request){
		$oldName=str_replace('@','/',$request->oldName);
		$newName=$request->newName;
		$path=$request->folderPath;
		$folder= str_replace('/', '\\',  storage_path('app/'.$oldName));
		$exists = Storage::disk('local')->exists(str_replace('/'.class_basename($oldName),'',$oldName).'/'.ucfirst($newName));
		if($exists){

session()->flash('message.type', 'danger');
		session()->flash('message.content', 'Impossible de renommer, ce fichier existe dejà!');

		}else{
			Storage::move($oldName, str_replace('/'.class_basename($oldName),'',$oldName).'/'.ucfirst($newName));
		session()->flash('message.type', 'success');
		session()->flash('message.content', 'Fichier renommé !');
		}

		
		return redirect()->route('media',['directory'=>$path]);
	}
	public function view($media){

	}
	public function download($media){
	}
	public function duplicate($media){
	}
	public function delete($media){
		$media=str_replace('@','/',$media);

		$folder= str_replace('/', '\\',  storage_path('app/'.$media));
		str_replace('/'.class_basename($media),'',$media);
		
		if(is_dir($folder)){
			Storage::deleteDirectory($media);
		}else{
			Storage::delete($media);
		}
	// session()->flash('message.type', 'success');
	// session()->flash('message.content', 'Le fichier '.class_basename($media).' a été supprimé');
 //    return redirect()->route('media',[
 //    	'directory'=>str_replace('/'.class_basename($media),'',$media)
 //    ]);
	}
	public function getProperties($media){
	}
	public function copy(){
	}
	public function paste(){
	}
}
