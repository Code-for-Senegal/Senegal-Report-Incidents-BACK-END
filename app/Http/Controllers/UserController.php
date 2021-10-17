<?php

namespace App\Http\Controllers;

use App\Models\Citoyen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return response()->json(User::all());
    }

    public function create(Request $request)
    {
        $user = new User();

        try {

            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->is_admin = 1;
            $user->save();

            $citoyen = new Citoyen();
            $citoyen->nom = $request->input('nom');
            $citoyen->prenom = $request->input('prenom');
            $citoyen->telephone = $request->input('telephone');
            $citoyen->is_adult = 0;
            $citoyen->user_id = $user->id;

            $citoyen->save();

        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

        return response()->json($user->email);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            if (!$token = Auth::attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            return response()->json($request->input('email'));
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }

    }
}
