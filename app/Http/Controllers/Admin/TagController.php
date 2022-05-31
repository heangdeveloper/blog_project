<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $tag = Tag::all();
            return datatables()->of($tag)
            ->addIndexColumn()
            ->addColumn('action', function($tag) {
                return '<a onclick="editData('. $tag->id .')" class="btn btn-primary btn-xs rounded-0 text-white"><i class="fa fa-edit"></i> Edit</a>' . ' <a onclick="deleteData('. $tag->id .')" class="btn btn-danger btn-xs rounded-0 text-white"><i class="fa fa-trash"></i> Delete</a>';
            })->make(true);
        }
        return view('admin.tags.index');
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
        $slug = Str::slug($request->title, '-');
        $tag = new Tag;
        $tag->title = $request->title;
        $tag->slug = $slug;
        $tag->description = $request->description;
        $tag->save();

        return response()->json($tag);
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
        return Tag::where('id', $id)->first();
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
        $slug = Str::slug($request->edit_title, '-');
        $tag = Tag::find($id);
        $tag->title = $request->edit_title;
        $tag->slug = $slug;
        $tag->description = $request->edit_description;
        $tag->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Tag::find($id)->delete();
    }
}
