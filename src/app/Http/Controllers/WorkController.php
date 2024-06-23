<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Breaking;

class WorkController extends Controller
{
    public function index()
    {
        return view('work');
    }

    public function attendance()
    {
        $works = Work::with('breaking')->pagenate(5);
        $breakings = Breaking::all();
        return view('attendance',compact('works','breakings'));
    }

    public function search(Request $request)
    {
        /*$work=Work::find($request->work_date)->show();*/
        $query = Work::query();
        $query = $this -> getSearchQuery($request,$query);
        $works = $query -> paginate(5);
        $breakings = Breaking::all();
        return view('attendance',compact('works','breakings'));
    }
}
