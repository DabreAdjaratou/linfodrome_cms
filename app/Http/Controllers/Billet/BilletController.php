<?php

namespace App\Http\Controllers\Billet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billet\Billet;
use App\Models\Billet\Archive;
use App\Models\Article\Source;
use App\Models\Billet\Category;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BilletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sources=Source::all();
        $categories=Category::all();
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
        'video'=>'nullable|string',
        'introtext'=>'nullable|string',
        'fulltext'=>'required|string',
        'source_id'=>'int',
        'created_by'=>'required|int',
        'start_publication_at'=>'nullable|string',
        'stop_publication_at'=>'nullable|int',

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
       $billet->video = $request->video;
       $billet->introtext = $request->introtext;
       $billet->fulltext =$request->fulltext;
       $billet->source_id = $request->source;
       $billet->created_by =$request->created_by;
       $billet->created_at =now();
       $billet->start_publication_at = $request->start_publication_at;
       $billet->stop_publication_at =$request->stop_publication_at;



       if ($billet->save()) {
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
       $archive->video = $lastRecord->video;
       $archive->introtext = $lastRecord->introtext;
       $archive->fulltext =$lastRecord->fulltext;
       $archive->source_id = $lastRecord->source_id;
       $archive->created_by =$lastRecord->created_by;
       $archive->created_at =$lastRecord->created_at;
       $archive->start_publication_at = $lastRecord->start_publication_at;
       $archive->stop_publication_at =$lastRecord->stop_publication_at;
       $archive->save();

        $request->session()->flash('message.type', 'success');
        $request->session()->flash('message.content', 'Billet ajouté avec succès!');
    } else {
        $request->session()->flash('message.type', 'danger');
        $request->session()->flash('message.content', 'Erreur lors de l\'ajout!');
    }

       if ($request->save_close) {
           return redirect()->route('users.index');
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
