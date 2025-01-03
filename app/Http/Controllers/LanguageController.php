<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Language::select(['id', 'language_name', 'language_code']);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a class="btn btn-info btn-sm" href="'.route('language.show', $row->id).'">Show</a>
                        <a class="btn btn-primary btn-sm" href="'.route('language.edit', $row->id).'">Edit</a>
                        <form method="POST" action="'.route('language.destroy', $row->id).'" style="display:inline">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('language.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Perform validation
        $validated = $request->validate([
            'language_name' => 'required|string|max:255',
            'language_code' => 'required|string|max:10',
        ]);
    
        // Create a new language record
        Language::create([
            'language_name' => $validated['language_name'],
            'language_code' => $validated['language_code'],
        ]);
    
        // Redirect with a success message
        return redirect()->route('language.index')->with('success', 'Language created successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('language.edit', compact('language'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Retrieve the existing language by ID
        $language = Language::findOrFail($id);
    
        // Validate the request data
        $validated = $request->validate([
            'language_name' => 'required|string|max:255',
            'language_code' => 'required|string|max:10',
        ]);
    
        // Update the existing language
        $language->update([
            'language_name' => $validated['language_name'],
            'language_code' => $validated['language_code'],
        ]);
    
        // Redirect with a success message
        return redirect()->route('language.index')->with('success', 'Language updated successfully!');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        //
    }
}
