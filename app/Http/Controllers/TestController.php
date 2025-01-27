<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $data = Test::all();
        return view('backend.tests.index', compact('data'));
    }

    public function create()
    {
        return view('backend.tests.create');
    }

        public function store(Request $request)
    {
        // Directly create the model with the incoming data
        Test::create($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('tests.index')->with('success', 'Test created successfully.');
    }
        
    public function edit($id)
    {
        $item = Test::findOrFail($id);
        return view('backend.tests.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        // Find the item by ID
        $item = Test::findOrFail($id);

        // Update the item with the incoming data
        $item->update($request->all());

        // Redirect to the index page with a success message
        return redirect()->route('tests.index')->with('success', 'Test updated successfully.');
    }
}