<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::all();
            return DataTables::of($cities)->make(true);
        }
        return view('City.index');
    }

    public function create()
    {
        return view('City.create');
    }

    public function store(Request $request)
    {
        City::create($request->all());
        return redirect()->route('City.index')->with('success', 'Created successfully.');
    }
}
