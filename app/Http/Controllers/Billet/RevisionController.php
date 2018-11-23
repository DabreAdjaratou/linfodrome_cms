<?php

namespace App\Http\Controllers\Billet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billet\Revision;
use App\Models\Billet\Archive;

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
         $revisions=Revision::with(['getModifier:id,name','getBillet:id,title,category_id,created_by,created_at','getBillet.getCategory:id,title','getBillet.getAuthor:id,name'])->get()->groupBy('billet_id');
   return view('billet.revisions.administrator.index',compact('revisions'));

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
     * @param  int  $billetId
     * @return \Illuminate\Http\Response
     */
    public function show($billetId)
    {
       $billet=Archive::with(['getRevision.getModifier:id,name','getCategory:id,title',
      'getAuthor:id,name'])->withTrashed()->where('id',$billetId)->get();
        return view('billet.revisions.administrator.show',compact('billet'));
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
