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


class VideoController extends Controller
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
     $videos = Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published','<>',2)->get(['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);

           return view ('video.videos.administrator.index', compact('videos'));

   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      session()->put('link',url()->previous());
      $categories=Category::where('published',1)->get(['id','title']);
      $users=User::all();
      return view ('video.videos.administrator.create',compact('categories','users'));
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
        'created_by'=>'int',
        'cameraman'=>'required|int',
        'editor'=>'required|int',
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
      $video->cameraman =$request->cameraman;
       $video->editor =$request->editor;
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
         $archive->cameraman =$lastRecord->cameraman;
         $archive->editor =$lastRecord->editor;
         $archive->created_at =$lastRecord->created_at;
         $archive->start_publication_at = $lastRecord->start_publication_at;
         $archive->stop_publication_at =$lastRecord->stop_publication_at;
         $archive->save();
         $oldest = Video::oldest()->first();
         $oldest->delete();
       });

     } catch (Exception $exc) {
      
      session()->flash('message.type', 'danger');
      
      session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
    }

    
    session()->flash('message.type', 'success');
    
    session()->flash('message.content', 'Video ajouté avec succès!');
    
    

    if ($request->save_close) {
     return redirect(session()->get('link'));
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

      session()->put('link',url()->previous());
      $video= Video::find($id);
      $archive=Archive::find($id);
      if($video->checkout!=0){
        if ($video->checkout!=Auth::id()) {
         session()->flash('message.type', 'warning');
         session()->flash('message.content', 'video dejà en cour de modification!');
         return redirect()->route('videos.index');
       }else{
      $categories=Category::where('published',1)->get(['id','title']);
        $users=user::all('id','name');
        return view('video.videos.administrator.edit',compact('video','categories','users'));
      }
    }else{
      $video->checkout=Auth::id();
      $archive->checkout=Auth::id();
      $archive->save();
      $video->save();
      $categories=Category::where('published',1)->get(['id','title']);
      $users=user::all('id','name');
      return view('video.videos.administrator.edit',compact('video','categories','users'));
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
      $video=Video::find($id);
      $video->title =$request->title;
      $video->alias =str_slug($request->title, '-');
      $video->category_id = $request->category;
      $video->published=$request->published ? $request->published : 0 ;
      $video->featured=$request->featured ? $request->featured : 0 ; 
      $video->image = $request->image ? $request->image : $video->image;
      $video->code = $request->video;
      $video->created_by =$request->created_by;
      $video->cameraman =$request->cameraman;
      $video->editor =$request->editor;
      $video->created_at =now();
      $video->start_publication_at = $request->start_publication_at;
      $video->stop_publication_at =$request->stop_publication_at;
$video->checkout=0;



      try {
       DB::transaction(function () use ($video,$request) {
         $archive=Archive::find($video->id);
         $archive->title =$video->title;
         $archive->alias =$video->alias;
         $archive->category_id = $video->category_id;
         $archive->published = $video->published;
         $archive->featured =$video->featured;
         $archive->image = $video->image;
         $archive->code = $video->code;
         $archive->created_by =$video->created_by;
         $archive->cameraman =$video->cameraman;
         $archive->editor =$video->editor;
         $archive->created_at =$video->created_at;
         $archive->start_publication_at = $video->start_publication_at;
         $archive->stop_publication_at =$video->stop_publication_at;
$archive->checkout=0;

        if ($request->update) {
       $video->save();
       $archive->save();
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
     });
           
       } catch (Exception $exc) {
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de la modification!');
//           echo $exc->getTraceAsString();
       }

    return redirect(session()->get('link'));
           
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
    $video=Video::onlyTrashed()->find($id)->forceDelete();
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Video supprimé avec success!');
    return redirect()->route('videos.trash');
    }
    
     public function putInDraft($id)
    {
      try {
       DB::transaction(function () use ($id) {
      $video=Video::find($id);
      $archive=Archive::find($id);
      $video->published=2;
      $archive->published=2;
      $video->save();
      $archive->save();
       $revision= new  Revision;
       $revision->type=explode('@', Route::CurrentRouteAction())[1];
       $revision->user_id=Auth::id();
       $revision->video_id=$id;
       $revision->revised_at=now();
       $revision->save();
     });
       session()->flash('message.type', 'success');
    session()->flash('message.content', 'Video mis en corbeille!');
    } catch (Exception $exc) {
      session()->flash('message.type', 'danger');
      session()->flash('message.content', 'Erreur lors de la mise en corbeille!');
//           echo $exc->getTraceAsString();
    }
    return back();
    }

    public function putInTrash($id)
    {
      try {
       DB::transaction(function () use ($id) {
    $video=Video::find($id)->delete();
    $archive=Archive::find($id)->delete();
     $revision= new  Revision;
       $revision->type=explode('@', Route::CurrentRouteAction())[1];
       $revision->user_id=Auth::id();
       $revision->video_id=$id;
       $revision->revised_at=now();
       $revision->save();
     });
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Video mis en corbeille!');
    } catch (Exception $exc) {
      session()->flash('message.type', 'danger');
      session()->flash('message.content', 'Erreur lors de la mise en corbeille!');
//           echo $exc->getTraceAsString();
    }
    return back();
    }

    public function restore($id)
    {
      try {
       DB::transaction(function () use ($id) {
      $video=Video::onlyTrashed()->find($id)->restore();
      $archive=Archive::onlyTrashed()->find($id)->restore();
       $revision= new  Revision;
       $revision->type=explode('@', Route::CurrentRouteAction())[1];
       $revision->user_id=Auth::id();
       $revision->video_id=$id;
       $revision->revised_at=now();
       $revision->save();
     });
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Video restaurer!');
      } catch (Exception $exc) {
      session()->flash('message.type', 'danger');
      session()->flash('message.content', 'Erreur lors de la restauration!');
//           echo $exc->getTraceAsString();
    }
      return redirect()->route('videos.index');
    }

    public function inTrash()
    {
       $videos=Video::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->get(['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
       return view('video.videos.administrator.trash',compact('videos'));
    }

public function inDraft()
    {
      $videos=Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published',2)->get(['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
        return view('video.videos.administrator.draft',compact('videos'));
  }
  }
