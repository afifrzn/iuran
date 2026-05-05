<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Participant::all(),
            'total' => Participant::sum('amount'),
            'count' => Participant::count()
        ]);
    }

    public function store(Request $req)
    {
        $amount = $req->with_meal ? 138000 : 100000;

        return Participant::create([
            'name' => $req->name,
            'with_meal' => $req->with_meal,
            'amount' => $amount
        ]);
    }

    public function upgrade($id)
    {
        $p = Participant::findOrFail($id);
        $p->with_meal = true;
        $p->amount = 138000;
        $p->save();

        return $p;
    }

public function bayar(Request $req, $id)
{
    $p = Participant::findOrFail($id);
    $p->paid = true;
    // $p->payment_method = $req->input('method');
    $p->save();

    return response()->json($p);
}
}