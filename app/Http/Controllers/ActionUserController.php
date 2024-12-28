<?php

namespace App\Http\Controllers;

use App\Models\ActionUser;
use App\Http\Requests\StoreActionUserRequest;
use App\Http\Requests\UpdateActionUserRequest;
use Illuminate\Support\Facades\Auth;

class ActionUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActionUserRequest $request)
    {
       
    
        $existingAction = ActionUser::where('type', $request->type)
            ->where('action', $request->action)
            ->where('user_id', auth()->user()->id)

            ->first();
            // print_r($existingAction);
    
        if ($existingAction) {
            $existingAction->delete();
            return response('deleted successfully');
        } else {
            $data = [
                'type' => $request->type,
                'action' => $request->action,
                'action_id' => $request->id,
                'user_id' =>auth()->user()->id
            ];
    
            ActionUser::create($data);
            return response( 'successfully');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(ActionUser $actionUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActionUser $actionUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActionUserRequest $request, ActionUser $actionUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActionUser $actionUser)
    {
        //
    }
}
