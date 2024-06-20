<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index()
    {
        return view('work');
    }

    public function search(Request $request)
    {
        Work::find($request->id)->show();
        return view('attendance',compact('works','breakings'));
    }
}
