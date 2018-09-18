<?php

namespace App\Http\Controllers\Billet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billet\Billet;
use App\Models\Billet\Archive;
use App\Models\Billet\Source;
use App\Models\Billet\Category;
use App\Models\User\User;
use App\Models\Billet\Revision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class BilletController extends Controller
{
     /**
     * Protecting routes
     */
    public function __construct()
{
    $this->middleware('auth');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $billets = Billet::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
   
   return view('billet.archives.index',['billets'=>$billets]);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sources=Source::all('id','title');
        $categories=Category::all('id','title');
        $users=user::all('id','name');
        $auth_username = Auth::user()->name;
       
      
        return view('billet.billets.create',['sources'=>$sources, 'categories'=>$categories,'auth_username'=>$auth_username, 'users'=>$users]);
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
        'ontitle'=>'nullable|string',
        'title' => 'required|string',
        'category'=>'required|int',
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'nullable|image',
        'image_legend'=>'nullable|string',
        'introtext'=>'nullable|string',
        'fulltext'=>'required|string',
        'source_id'=>'int',
        // 'created_by'=>'int',
        'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
        'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',

    ]);

       $billet= new Billet;
       $billet->ontitle = $request->ontitle;
       $billet->title =$request->title;
       $billet->alias =str_slug($request->title, '-');
       $billet->category_id = $request->category;
       $billet->published=$request->published ? $request->published : 0 ;
       $billet->featured=$request->featured ? $request->featured : 0 ;
       $billet->image = $request->image;
       $billet->image_legend =$request->image_legend;
       $billet->introtext = $request->introtext;
       $billet->fulltext =$request->fulltext;
       $billet->source_id = $request->source;
       $billet->created_by =$request->created_by ?? $request->auth_userid;
       $billet->created_at =now();
       $billet->start_publication_at = $request->start_publication_at;
       $billet->stop_publication_at =$request->stop_publication_at;



       try {
           DB::transaction(function () use ($billet) {
       $billet->save();
       $lastRecord= Billet::latest()->first();
       $archive= new Archive;
       $archive->id = $lastRecord->id;
       $archive->ontitle = $lastRecord->ontitle;
       $archive->title =$lastRecord->title;
       $archive->alias =$lastRecord->alias;
       $archive->category_id = $lastRecord->category_id;
       $archive->published = $lastRecord->published;
       $archive->featured =$lastRecord->featured;
       $archive->image = $lastRecord->image;
       $archive->image_legend =$lastRecord->image_legend;
       $archive->introtext = $lastRecord->introtext;
       $archive->fulltext =$lastRecord->fulltext;
       $archive->source_id = $lastRecord->source_id;
       $archive->created_by =$lastRecord->created_by;
       $archive->created_at =$lastRecord->created_at;
       $archive->start_publication_at = $lastRecord->start_publication_at;
       $archive->stop_publication_at =$lastRecord->stop_publication_at;
       $archive->save();
       // $oldest = Billet::oldest()->first();
       // $oldest->delete();
});
           
       } catch (Exception $exc) {
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
       }

       session()->flash('message.type', 'success');
       session()->flash('message.content', 'Billet ajouté avec succès!');
    

       if ($request->save_close) {
           return redirect()->route('billets.index');
       }else{
        return redirect()->route('billets.create');
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

      $billet= Billet::find($id);
      $sources=Source::all('id','title');
      $categories=Category::all('id','title');
      $users=user::all('id','name');
      return view('billet.billets.edit',compact('billet','sources','categories','users'));
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
        'ontitle'=>'nullable|string',
        'title' => 'required|string',
        'category'=>'required|int',
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'nullable|image',
        'image_legend'=>'nullable|string',
        'introtext'=>'nullable|string',
        'fulltext'=>'required|string',
        'source_id'=>'int',
        // 'created_by'=>'int',
        'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
        'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',

    ]);
      $billet=Billet::find($id);
     if (is_null($billet)) {
     $billet=Archive::find($id);
     }
       $billet->ontitle = $request->ontitle;
       $billet->title =$request->title;
       $billet->alias =str_slug($request->title, '-');
       $billet->category_id = $request->category;
       $billet->published=$request->published ? $request->published : 0 ;
       $billet->featured=$request->featured ? $request->featured : 0 ; 
       $billet->image = $request->image;
       $billet->image_legend =$request->image_legend;
       $billet->introtext = $request->introtext;
       $billet->fulltext =$request->fulltext;
       $billet->source_id = $request->source;
       $billet->created_by =$request->created_by ?? $request->auth_userid;
       $billet->created_at =now();
       $billet->start_publication_at = $request->start_publication_at;
       $billet->stop_publication_at =$request->stop_publication_at;

       try {
           DB::transaction(function () use ($billet,$request) {
       $archive= Archive::find($billet->id);
       $archive->ontitle = $billet->ontitle;
       $archive->title =$billet->title;
       $archive->alias =$billet->alias;
       $archive->category_id = $billet->category_id;
       $archive->published = $billet->published;
       $archive->featured =$billet->featured;
       $archive->image = $billet->image;
       $archive->image_legend =$billet->image_legend;
       $archive->introtext = $billet->introtext;
       $archive->fulltext =$billet->fulltext;
       $archive->source_id = $billet->source_id;
       $archive->created_by =$billet->created_by;
       $archive->created_at =$billet->created_at;
       $archive->start_publication_at = $billet->start_publication_at;
       $archive->stop_publication_at =$billet->stop_publication_at;
       if ($request->update) {
       $billet->save();
       $archive->save();
      $revision= new  Revision;
 $revision->type=explode('@', Route::CurrentRouteAction())[1];
 $revision->user_id=Auth::id();
 $revision->billet_id=$billet->id;
 $revision->revised_at=now();
 $revision->save();
       session()->flash('message.type', 'success');
       session()->flash('message.content', 'Billet modifié avec succès!');
           
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

           return redirect()->route('billets.index');
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
