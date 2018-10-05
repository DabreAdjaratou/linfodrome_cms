<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(){
$directories=Storage::directories('public/images');
$files=Storage::files('public/images');
return view('media.administrator.index',compact('directories','files'));
    }

    public function mediaChild(){
    	return view('media.administrator.media-child');
    }

}
