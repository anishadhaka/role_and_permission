<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\module;
// use App\Models\CompanyAddress;
use DataTables;

class CompanyController extends Controller
{
    // Fetch company data for DataTables
    public function getDataAjax(Request $request)
    {
        if ($request->ajax()) {
            $companies = module::with('parent')->get();

            return DataTables::of($companies)
                ->addColumn('parent', function ($row) {
                    return $row->parent ? $row->parent->name : 'N/A';
                })
                ->addColumn('address', function ($row) {
                    return '<button class="btn btn-info view-address-btn" data-company-id="' . $row->id . '">View Addresses</button>';
                })
                ->addColumn('actions', function ($row) {
                    return '<a href="' . route('module.edit', $row->id) . '" class="btn btn-primary">Edit</a>
                            <form action="' . route('module.destroy', $row->id) . '" method="POST" style="display:inline-block;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>';
                })
                ->rawColumns(['address', 'actions'])
                ->make(true);
        }
    }

    // Fetch addresses for a specific company
    public function getCompanyAddress(Request $request)
    {
        $companyId = $request->company_id;

        $addresses = CompanyAddress::where('company_id', $companyId)->get();

        if ($addresses->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No addresses found']);
        }

        return response()->json(['status' => 'success', 'data' => $addresses]);
    }

    // Save addresses for a company
    public function saveCompanyAddress(Request $request)
    {
        $companyId = $request->company_id;
        $addresses = $request->input('address');
        $mobiles = $request->input('mobile');
        $latitudes = $request->input('latitude');
        $longitudes = $request->input('longitude');
        $ids = $request->input('id'); // Existing IDs (if editing)

        if (!$addresses || count($addresses) === 0) {
            return response()->json(['status' => 'error', 'message' => 'No addresses provided']);
        }

        foreach ($addresses as $index => $address) {
            if (isset($ids[$index]) && $ids[$index]) {
                // Update existing address
                $companyAddress = CompanyAddress::find($ids[$index]);
                if ($companyAddress) {
                    $companyAddress->update([
                        'address' => $address,
                        'mobile' => $mobiles[$index],
                        'latitude' => $latitudes[$index],
                        'longitude' => $longitudes[$index],
                    ]);
                }
            } else {
                // Create new address
                CompanyAddress::create([
                    'company_id' => $companyId,
                    'address' => $address,
                    'mobile' => $mobiles[$index],
                    'latitude' => $latitudes[$index],
                    'longitude' => $longitudes[$index],
                ]);
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Addresses saved successfully']);
    }

    // Delete a specific address
    public function deleteCompanyAddress(Request $request)
    {
        $addressId = $request->address_id;

        $address = CompanyAddress::find($addressId);
        if (!$address) {
            return response()->json(['status' => 'error', 'message' => 'Address not found']);
        }

        $address->delete();
        return response()->json(['status' => 'success', 'message' => 'Address deleted successfully']);
    }
}
