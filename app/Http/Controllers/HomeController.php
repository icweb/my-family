<?php

namespace App\Http\Controllers;

use App\Family;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
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
    public function index()
    {
        $families = Family::all();

        $family = Family::findOrFail($_GET['family']);
        $children = User::where(['parent_1_id' => $family->father->id])->orWhere(['parent_2_id' => $family->mother->id])->get();

        return view('home', [
            'family' => $family,
            'families' => $families,
            'children' => $children
        ]);
    }
}
