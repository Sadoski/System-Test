<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $this->authorize('is_admin');
        $user = User::all();

        if($request->name)
        {
            $user = User::where('name', 'like',  '%'.$request->name.'%')->get();
        }

        return view('user', compact('user'));
    }

    public function create()
    {
        $this->authorize('is_admin');

        $user = new User;
        $profile = $user->roles();
        
        return view('auth.register')->with('profiles', $profile);
    }

    public function store(Request $request)
    {
        $this->authorize('is_admin');

        $user = new User;

        $request->request->add(['status' => 'ATIVO'] );
        $request->request->add(['user_created_user_id' => Auth::id()] );

        $rules = $user->rules();
        $rules['user_created_user_id'] = $rules['user_created_user_id'] . ',' . Auth::id();
        $request->validate($rules);
        dd('passou');
        $user->create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'status' => $request['status'],
                'profile' => $request['profile'],
                'user_created_user_id' => Auth::id(),
        ]);

        return redirect()->route('user')->with('success', 'Usuário criado com sucesso!');
    }

    public function show($id)
    {
        $this->authorize('is_admin');

        $users = new User;
        $user = $users->find($id);

        if(is_null($user)) {
            abort(404);
        }
        return view('show_user', compact('user'));
    }

    public function edit($id)
    {
        $this->authorize('is_admin');

        $users = new User;
        $user = $users->find($id);
        
        if(is_null($user)) {
            abort(404);
        }
        return view('edit_user', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('is_admin');

        $dataUser = $user->find($request->id_user);

        if(is_null($dataUser)) {
            abort(404);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$request->id_user.',id_user',
        ];
        
        $request->validate($rules);

        $dataUser->update($request->all());

        return redirect()->route('user')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id, User $user)
    {
        $this->authorize('is_admin');

        $dataUser = $user->find($id);

        if(is_null($dataUser)) {
            abort(404);
        }

        $dataUser->delete();
        return redirect()->route('user')->with('success', 'Usuário deletado com sucesso!');
    }
}
