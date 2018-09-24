<?php

namespace App\Http\Controllers\Banner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner\Banner;
use App\Models\Banner\Category;
use App\Models\User\User;
use Illuminate\Validation\Rule;

class BannerController extends Controller
{

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
        $banners=Banner::with(['getCategory:id,title','getAuthor:id,name'])->get();
        return view('banner.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all('id','title');
        $users=User::all('id','name');
     return view('banner.banners.create',compact('categories','users'));   
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
      
      'title' => 'required|unique:banners|max:100',
      'published'=>'nullable',
      'category'=>'required|int',
      'type'=>'required|int',
      'imageForComputer'=>'image',
      'imageForTablet'=>'image',
      'imageForMobile'=>'image',
      'sizeForComputer'=>'string',
      'sizeForTablet'=>'string',
      'sizeForMobile'=>'string',
      'url'=>'required|string',
      'codeForComputer'=>'string',
      'codeForTablet'=>'string',
      'codeForMobile'=>'string',
            // 'created_by'=>'int',
      'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
      'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',

    ]);

        $banner=new Banner;
        $banner->title=$request->title;
        $banner->alias =str_slug($request->title, '-');
        $banner->published=$request->published ? $request->published : 0 ;
        $banner->category_id=$request->category;
        $banner->type=$request->type;
        $banner->image='{"computer":"'.str_replace('\\', '/',$request->imageForComputer).'","tablet":"'.str_replace('\\', '/',$request->imageForTablet).'","mobile":"'.str_replace('\\', '/',$request->imageForMobile).'"}';
        $banner->size='{"computer":"'.$request->sizeForComputer.'","tablet":"'.$request->sizeForTablet.'","mobile":"'.$request->sizeForMobile.'"}';
        $banner->url=$request->url;
        $banner->code='{"computer":"'.$request->codeForComputer.'","tablet":"'.$request->codeForTablet.'","mobile":"'.$request->codeForMobile.'"}';
        $banner->created_by=$request->created_by ?? $request->auth_userid;
        $banner->start_publication_at=$request->start_publication_at;
        $banner->stop_publication_at=$request->stop_publication_at;
        
  if ($banner->save()) {
        session()->flash('message.type', 'success');
        session()->flash('message.content', 'Bannière ajouté avec succès!');
    } else {
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de l\'ajout!');
    }
       if ($request->save_close) {
           return redirect()->route('banners.index');
       }else{
        return redirect()->route('banners.create');
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
        $banner=Banner::find($id);
        $categories=Category::all('id','title');
        $users=User::all('id','name');
        return view('banner.banners.edit',compact('banner','categories','users'));
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
      'title' => 'required|'.Rule::unique('banners')->ignore($id, 'id'),
      'published'=>'nullable',
      'category'=>'required|int',
      'type'=>'required|int',
      'imageForComputer'=>'image',
      'imageForTablet'=>'image',
      'imageForMobile'=>'image',
      'sizeForComputer'=>'string',
      'sizeForTablet'=>'string',
      'sizeForMobile'=>'string',
      'url'=>'required|string',
      'codeForComputer'=>'string',
      'codeForTablet'=>'string',
      'codeForMobile'=>'string',
            // 'created_by'=>'int',
      'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
      'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
    ]);

        $banner=Banner::find($id);
        $banner->title=$request->title;
        $banner->alias =str_slug($request->title, '-');
        $banner->published=$request->published ? $request->published : 0 ;
        $banner->category_id=$request->category;
        $banner->type=$request->type;
        $exixtingImages=$banner->image;
                
        $request->imageForComputer= $request->imageForComputer ? $request->imageForComputer: json_decode($exixtingImages)->computer;
        $request->imageForTablet= $request->imageForTablet ? $request->imageForTablet:json_decode($exixtingImages)->tablet;
        $request->imageForMobile= $request->imageForMobile ? $request->imageForMobile:json_decode($exixtingImages)->mobile;
        $banner->image='{"computer":"'.str_replace('\\', '/',$request->imageForComputer).'","tablet":"'.str_replace('\\', '/',$request->imageForTablet).'","mobile":"'.str_replace('\\', '/',$request->imageForMobile).'"}';
        $banner->size='{"computer":"'.$request->sizeForComputer.'","tablet":"'.$request->sizeForTablet.'","mobile":"'.$request->sizeForMobile.'"}';
        $banner->url=$request->url;
        $banner->code='{"computer":"'.$request->codeForComputer.'","tablet":"'.$request->codeForTablet.'","mobile":"'.$request->codeForMobile.'"}';
        $banner->created_by=$request->created_by ?? $request->auth_userid;
        $banner->start_publication_at=$request->start_publication_at;
        $banner->stop_publication_at=$request->stop_publication_at;
        
  if ($request->update) {
        if ($banner->save()) {
           
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Bannière modifiée avec succès!');
        } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Erreur lors de la modification!');
        }
    }else{
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Modification annulée!');
    }
           return redirect()->route('banners.index');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    $banner=Banner::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', ' bannière supprimée avec success!');
    return redirect()->route('banners.trash');  
        
    }
    
     public function putInTrash($id)
    {
    $banner=Banner::find($id)->delete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Bannière mis en corbeille!');
    return redirect()->route('banners.index');
    }

    public function restore($id)
    {
       $banner=Banner::onlyTrashed()->find($id)->restore();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Bannière restaurer!');
      return redirect()->route('banners.index');
    
    }

    public function inTrash()
    {
    $banners=Banner::onlyTrashed()->with(['getCategory:id,title','getAuthor:id,name'])->get();
       return view('banner.banners.trash',compact('banners'));      
    }
}
