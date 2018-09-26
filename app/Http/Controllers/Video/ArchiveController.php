<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video\Category;
use App\Models\User\User;
use App\Models\Video\Video;
use App\Models\Video\Archive;
use App\Models\Video\Revision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ArchiveController extends Controller
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
       $videos = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published','<>',2)->get(['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
        
       return view ('video.archives.administrator.index', compact('videos'));
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
      $video=Video::find($id);
      if ($video) {
        return redirect()->route('videos.edit',['video'=>$video]);
    }else{

        $video=Archive::find($id);
        if($video->checkout!=0){
        if ($video->checkout!=Auth::id()) {
         session()->flash('message.type', 'warning');
         session()->flash('message.content', 'video dejà en cour de modification!');
         return redirect()->route('video-archives.index');
       }else{
      $categories=Category::where('published',1)->get(['id','title']);
        $users=user::all('id','name');
        return view('video.archives.administrator.edit',compact('video','categories','users'));
      }
    }else{
      $video->checkout=Auth::id();
      $video->save();
      $categories=Category::where('published',1)->get(['id','title']);
       $users=user::all('id','name');
       return view ('video.archives.administrator.edit',compact('video','categories','users'));
    }
      
    }
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
        $validatedData = $request->validate([
        'title' => 'required|string',
        'category'=>'required|int',
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'image',
        'video'=>'required|string',
        'created_by'=>'int',
        'cameraman'=>'required|int',
        'editor'=>'required|int',
        'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
        'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
      ]);
      $video=Archive::find($id);
      $video->title =$request->title;
      $video->alias =str_slug($request->title, '-');
      $video->category_id = $request->category;
      $video->published=$request->published ? $request->published : 0 ;
      $video->featured=$request->featured ? $request->featured : 0 ; 
      $video->image = $request->image ? $request->image:$video->image;
      $video->code = $request->video;
      $video->created_by =$request->created_by;
      $video->cameraman =$request->cameraman;
      $video->editor =$request->editor;
      $video->created_at =now();
      $video->start_publication_at = $request->start_publication_at;
      $video->stop_publication_at =$request->stop_publication_at;
$video->checkout=0;
       if ($request->update) {
       $video->save();
       $revision= new  Revision;
       $revision->type=explode('@', Route::CurrentRouteAction())[1];
       $revision->user_id=Auth::id();
       $revision->video_id=$video->id;
       $revision->revised_at=now();
       $revision->save();
       session()->flash('message.type', 'success');
       session()->flash('message.content', 'Video modifié avec succès!');
           
      }else{
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Modification annulée!');
    }
     

           return redirect()->route('video-archives.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video=Video::onlyTrashed()->find($id);
        if($video){
            return redirect()->route('videos.destroy',compact('video'));
        }else{
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Video supprimé avec success!');
    return redirect()->route('video-archives.index');
    }
    }

     public function putInDraft($id)
    {
      $video=Video::find($id);
      if ($video) {
        return redirect()->route('videos.put-in-draft',compact('video'));
      }else{
      $archive=Archive::find($id);
      $archive->published=2;
      $archive->save();
      return redirect()->route('video-archives.index');
    }
}

    public function putInTrash($id)
    {
       $video=Video::find($id);
      if ($video) {
        return redirect()->route('videos.put-in-trash',compact('video'));
      }else{
    $archive=Archive::find($id)->delete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Video mis en corbeille!');
}
    return redirect()->route('video-archives.index');
    }

    public function restore($id)
    {
         $video=Video::find($id);
      if ($video) {
        return redirect()->route('videos.restore',compact('video'));
      }else{
      $archive=Archive::onlyTrashed()->find($id)->restore();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Video restaurer!');
  }
      return redirect()->route('video-archives.index');
    }

    public function inTrash()
    {
       $archives=Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->get(['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
       return view('video.archives.administrator.trash',compact('archives'));
    }

public function inDraft()
    {
      $archives=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published',2)->get(['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
        return view('video.archives.administrator.draft',compact('archives'));
  }


     public function revision()
  {
    $videos= Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','created_by','created_at']);
    return view('video.archives.administrator.revision',compact('videos'));
  }
}
