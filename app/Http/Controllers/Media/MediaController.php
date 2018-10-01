<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function index(){
    	return view('media.administrator.index');
    }

    public function mediaChild(){
    	return view('media.administrator.media-child');
    }
}
