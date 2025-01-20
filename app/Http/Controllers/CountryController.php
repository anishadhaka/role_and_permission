<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $countries = Country::select(['id','name' ,'country_code','time_zone']);
            return DataTables::of($countries)->make(true);
        }
        
        return view('backend.Country.index');
    }

    public function create()
    {
        return view('backend.Country.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required|unique:country,country_name|max:255',
        ]);

        Country::create($request->all());
        return redirect()->route('Country.index')->with('success', 'Country created successfully.');
    }
}
