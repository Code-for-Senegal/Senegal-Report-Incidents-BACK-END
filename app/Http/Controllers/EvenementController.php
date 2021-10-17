<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\User;
use Illuminate\Http\Request;

class EvenementController extends Controller
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

    public function create(Request $request)
    {
        try {
            $token = $request->input('_token');
            $user = User::where('email', '=', $token)->first();

            $evenement = new Evenement();
            $evenement->type_incident_id = $request->input('type_incident');
            $evenement->user_id = $user->id;
            $evenement->date = $request->input('date');
            $evenement->heure = $request->input('heure');
            $evenement->details = $request->input('details');
            $evenement->confirmed = 0;

            $evenement->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => true, 'error' => $e->getMessage()]);
        }
    }

    public function myEvenements($email)
    {
        $user = User::where('email', '=', $email)->first();

        return response()->json(Evenement::where('user_id', '=', $user->id)->get());
    }

    public function index()
    {
        return response()->json(Evenement::all());
    }
}
