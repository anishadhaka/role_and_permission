<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Http\Requests\StoreDomainRequest;
use App\Http\Requests\UpdateDomainRequest;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Domain::select(['id', 'domain_name', 'company_name', 'server_address', 'port', 'authentication', 'user_name', 'to_mail_id']);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a class="btn btn-info btn-sm" href="'.route('domain.show', $row->id).'">Show</a>
                        <a class="btn btn-primary btn-sm" href="'.route('domain.edit', $row->id).'">Edit</a>
                        <form method="POST" action="'.route('domain.destroy', $row->id).'" style="display:inline">
                            '.csrf_field().method_field('DELETE').'
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('domain.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('domain.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'domain_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'server_address' => 'required|string|max:255',
            'port' => 'required|integer',
            'authentication' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'to_mail_id' => 'required|integer',
            'mail_header' => 'string',
            'mail_footer' => 'string',
        ]);
    
        Domain::create($request->all());
    
        return redirect()->route('domain.index')
            ->with('success', 'Domain created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Domain $domain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $domain = Domain::findOrFail($id);
        return view('domain.edit', compact('domain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
   
{
    $request->validate([
        'domain_name' => 'required|string|max:255',
        'company_name' => 'required|string|max:255',
        'server_address' => 'required|string|max:255',
        'port' => 'required|integer',
        'authentication' => 'required|string|max:255',
        'user_name' => 'required|string|max:255',
        'to_mail_id' => 'required|integer',
        'mail_header' => 'nullable|string',
        'mail_footer' => 'nullable|string',
    ]);

    $domain = Domain::findOrFail($id);
    $domain->update($request->all());

    return redirect()->route('domain.index')
        ->with('success', 'Domain updated successfully.');
}
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Domain::where('id',$id)->firstOrFail()->delete();
        
        return redirect()->route('domain.index')
                        ->with('success','User deleted successfully');
    }
}
