<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class StateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $state = State::all();
            return DataTables::of($state)->make(true);
        }
        return view('State.index');
    }

    public function create()
    {
        return view('State.create');
    }

    public function store(Request $request)
    {
        State::create($request->all());
        return redirect()->route('State.index')->with('success', 'Created successfully.');
    }
}
