<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserApiController extends Controller
{
    public function __construct() 
    { 
        $this->middleware('auth.role:ADMINISTRADOR'); 
    }

    public function blockUser() 
    { 
        return 'Acesso não autorizado!'; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('is_admin_api');
        $user = User::all();

        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('is_admin_api');

        $user = new User;

        $request->request->add(['status' => 'ATIVO'] );
        
        $validator = Validator::make($request->all(), $user->rules());

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $user->create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'status' => $request['status'],
                'profile' => $request['profile'],
                'user_created_user_id' => $user->getIdUserApi(),
        ]);

        return response()->json($user, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('is_admin_api');

        $users = new User;
        $user = $users->find($id);

        if(is_null($user)) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('is_admin_api');

        $dataUser = $user->find($request->id_user);

        if(is_null($dataUser)) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$request->id_user.',id_user',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $dataUser->update($request->all());

        return response()->json($dataUser, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, User $user)
    {
        $this->authorize('is_admin_api');

        $dataUser = $user->find($id);

        if(is_null($dataUser)) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        $dataUser->delete();
        return response()->json(null, 200);
    }
}
