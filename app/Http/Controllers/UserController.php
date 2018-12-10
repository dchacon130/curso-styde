<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        //constructor de consultas
    	//$users = DB::table('users')->get();

        $users = User::all();
        //dd($users);

    	$title = 'Listado de usuarios';

    	return view('users.index')
    	->with('users',$users)
    	->with('title',$title);
    }

    public function show(User $user){

        //Remplazo por findOrFail
        /*if($user == null){
            return response()->view('errors.404', [], 404);
        }*/
        //$user = User::findOrFail($id);

    	return view('users.show', compact('user'));
    	//->with('user',$user);
    }

    public function create(){
    	return view('users.create');
    }

    public function store(){

        //Tambien existe Only que recibe solo los campos nombrados
        //$data = request()->only(['name', 'email', 'password']);

        //$data = request()->all();

        // if (empty($data['name'])) {
        //     return redirect()->route('users.index')
        //         ->withErrors([
        //             'name' => 'El campo nombre es obliugatorio'
        //         ]);
        // }

        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ],[
            'name.required' => 'El campo nombre es obligatorio'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        //return redirect('usuarios/nuevo')->withInput();
        return redirect()->route('users.index')->withInput();
    }

    public function edit(User $user){

        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user){

        //$data = request()->all();
        /*$data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'required'
        ]);

        $data['password'] = bcrypt($data['password']);*/
        
         $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => '',
        ]);

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.show', ['user' => $user]);
    }

    public function destroy(User $user){

        $user->delete();

        return redirect()->route('users.index');
    }
}
