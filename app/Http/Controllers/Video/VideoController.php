<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video\Category;
use App\Models\User\User;
use App\Models\Video\Video;
use App\Models\Video\Archive;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $videos = Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','published','featured','created_by','created_at','start_publication_at','stop_publication_at','views']);
       return view ('video.archives.index', ['videos'=>$videos]);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
        $categories=Category::all();
        $users=User::all();
        return view ('video.videos.create',['categories'=>$categories,'users'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'title' => 'required|string',
        'category'=>'required|int',
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'required|image',
        'video'=>'required|string',
        'created_by'=>'required|int',
        'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
        'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',

    ]);

       $video= new Video;
       $video->title =$request->title;
       $video->alias =str_slug($request->title, '-');
       $video->category_id = $request->category;
       $video->published=$request->published ? $request->published : 0 ;
       $video->featured=$request->featured ? $request->featured : 0 ; 
       $video->image = $request->image;
       $video->code = $request->video;
       $video->created_by =$request->created_by;
       $video->created_at =now();
       $video->start_publication_at = $request->start_publication_at;
       $video->stop_publication_at =$request->stop_publication_at;



        try {
       DB::transaction(function () use ($video) {
       $video->save();
       $lastRecord= Video::latest()->first();
       $archive= new Archive;
       $archive->id = $lastRecord->id;
       $archive->title =$lastRecord->title;
       $archive->alias =$lastRecord->alias;
       $archive->category_id = $lastRecord->category_id;
       $archive->published = $lastRecord->published;
       $archive->featured =$lastRecord->featured;
       $archive->image = $lastRecord->image;
       $archive->code = $lastRecord->code;
       $archive->created_by =$lastRecord->created_by;
       $archive->created_at =$lastRecord->created_at;
       $archive->start_publication_at = $lastRecord->start_publication_at;
       $archive->stop_publication_at =$lastRecord->stop_publication_at;
       $archive->save();
       $oldest = Video::oldest()->first();
       $oldest->delete();
});
           
       } catch (Exception $exc) {
        $request->session()->flash('message.type', 'danger');
        $request->session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
       }

       $request->session()->flash('message.type', 'success');
       $request->session()->flash('message.content', 'Billet ajouté avec succès!');
    
    

       if ($request->save_close) {
           return redirect()->route('video-archives.index');
       }else{
        return redirect()->route('videos.create');
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
