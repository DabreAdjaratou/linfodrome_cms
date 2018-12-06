<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video\Revision;
use App\Models\Video\Archive;

class RevisionController extends Controller
{
     /**
     * Protecting routes
     */
     public function __construct()
     {
       $this->middleware(['auth','activeUser']);
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $revisions=Revision::with(['getModifier:id,name','getVideo:id,title,category_id,created_by,created_at','getVideo.getCategory:id,title','getVideo.getAuthor:id,name'])->get()->groupBy('video_id');
       return view('video.revisions.administrator.index',['revisions'=>$revisions]);
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $videoId
     * @return \Illuminate\Http\Response
     */
    public function show($videoId)
    {
       
     $video=Archive::with(['getRevision.getModifier:id,name','getCategory:id,title',
      'getAuthor:id,name'])->withTrashed()->where('id',$videoId)->get();
     return view('video.revisions.administrator.show',compact('video'));
 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
