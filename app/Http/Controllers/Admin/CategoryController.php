<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $category = Category::all();
            return datatables()->of($category)
            ->addIndexColumn()
            ->addColumn('action', function($category) {
                return '<a class="btn btn-primary btn-xs rounded-0 text-white" onclick="editData('. $category->id .')"><i class="fa fa-edit"></i> Edit</a>' . ' <a class="btn btn-danger btn-xs rounded-0 text-white" onclick="deleteData('. $category->id .')"><i class="fa fa-trash"></i> Delete</a>';
            })->make(true);
        }
        
        return view('admin.category.index');
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
        $category = new Category;
        $category->title = $request->title;
        $category->slug = $slug;
        $category->description = $request->description;
        $category->save();

        return response()->json($category);
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
        return Category::where('id', $id)->first();
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
        $categorie = Category::find($id);
        $categorie->title = $request->edit_title;
        $categorie->slug = $slug;
        $categorie->description = $request->edit_description;
        $categorie->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Category::find($id)->delete();
    }
}
