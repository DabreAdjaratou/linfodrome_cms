<?php

namespace App\Http\Controllers\Billet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billet\Archive;
use App\Models\Billet\Billet;

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

        $billets = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
   
   return view('billet.archives.index',['billets'=>$billets]);
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
        $billet=Billet::onlyTrashed()->find($id);
        if($billet){
            return redirect()->route('billets.destroy',compact('billet'));
        }else{
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Billet supprimé avec success!');
    return redirect()->route('billet-archives.index');
    }
    }

     public function putInDraft($id)
    {
      $billet=Billet::find($id);
      if ($billet) {
        return redirect()->route('billets.put-in-draft',compact('billet'));
      }else{
      $archive=Archive::find($id);
      $archive->published=2;
      $archive->save();
      return redirect()->route('billet-archives.index');
    }
}

    public function putInTrash($id)
    {
       $billet=Billet::find($id);
      if ($billet) {
        return redirect()->route('billets.put-in-trash',compact('billet'));
      }else{
    $archive=Archive::find($id)->delete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Billet mis en corbeille!');
}
    return redirect()->route('billet-archives.index');
    }

    public function restore($id)
    {
         $billet=Billet::find($id);
      if ($billet) {
        return redirect()->route('billets.restore',compact('billet'));
      }else{
      $archive=Archive::onlyTrashed()->find($id)->restore();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'billet restaurer!');
  }
      return redirect()->route('billet-archives.index');
    }

    public function inTrash()
    {
       $archives=Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published','<>',2)->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
       return view('billet.archives.trash',compact('archives'));
    }

public function inDraft()
    {
      $archives=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published',2)->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
        return view('billet.archives.draft',compact('archives'));
  }


    public function revision()
  {
    $billets= Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','created_by','created_at']);
    return view('billet.archives.revision',['billets'=>$billets]);
  }
}
