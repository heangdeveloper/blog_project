<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $model = User::with('roles')->selectRaw('distinct users.*');
            return datatables()->of($model)
            ->addIndexColumn()
            ->addColumn('action', function($model) {
                return '<a onclick="editData('. $model->id .')" class="btn btn-primary btn-xs rounded-0 text-white"><i class="fa fa-edit"></i> Edit</a>' . ' <a onclick="deleteData('. $model->id .')" class="btn btn-danger btn-xs rounded-0 text-white"><i class="fa fa-trash"></i> Delete</a>';
            })
            ->addColumn('role_name', function ($user) {
                return $user->roles->map(function($role) {
                    return $role->name;
                });
            })
            ->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        return view('admin.users.create', [
            'role' => $role
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = $request->file('profile_photo_path');
        
        if(isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $currentDate.'-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('user'))
            {
                Storage::disk('public')->makeDirectory('user');
            }

            $postImage = Image::make($image)->resize(128,128)->stream();
            Storage::disk('public')->put('user/'.$imageName, $postImage);
        } else{
            $imageName = "default.png";
        }

        $role = Role::find($request->role);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_photo_path' => $imageName
        ]);

        $user->roles()->attach($role);
        return redirect()->route('admin.user.index');
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
