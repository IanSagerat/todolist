<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lists;
use App\Http\Resources\ListResource;
use Illuminate\Support\Facades\Validator;

class ListController extends Controller
{
    public function index() 
    {
        $list = Lists::get();
        if ($list->count() > 0)
        {
            return ListResource::collection($list);
        }
        else
        {
            return response()->json(['message' => 'No Record Available'], 200);
        }
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'list_name' => 'required|string|max:255',
            'list_desc' => 'required|string|max:255',
        ]);
    
        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }
    
        // Create the list using the correct field names
        $list = Lists::create([
            'list_name' => $request->list_name,
            'list_desc' => $request->list_desc,
            'list_status' => $request->list_status ?? 'Incomplete',
        ]);
    
        return response()->json([
            'message' => 'New Activity Created Successfully', 
            'data' => new ListResource($list)
        ], 200);
    }
     
    public function show(Lists $list) 
    {
        return new ListResource($list); 
    }

    public function patch(Request $request, Lists $list) 
    {
        $validator = Validator::make($request->all(), [
            'list_status' => 'required|in:Completed', // Accept only 'Completed'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
    
        // Update only the list_status to 'Completed'
        $list->update(['list_status' => 'Completed']);
        
        return response()->json([
            'message' => 'Activity status updated to Completed successfully', 
            'data' => new ListResource($list)
        ], 200);
    }
    
    public function update(Request $request, Lists $list) 
    {
        $validator = Validator::make($request->all(),[
            'list_name' => 'required|string|max:255',
            'list_desc' => 'required|string|max:255',
        ]);
    
        if($validator->fails())
        {
            return response()->json(['error' => $validator->messages()], 422);
        }
    
        $list->update([
            'list_name' => $request->list_name,
            'list_desc' => $request->list_desc,
            'list_status' => $request->list_status,
        ]);
    
        return response()->json([
            'message' => 'Activity Updated Successfully', 
            'data' => new ListResource($list)
        ], 200);
    }
    
    public function destroy(Lists $list) 
    {
        $list->delete();
        return response()->json([
            'message' => 'Activity Deleted Successfully'
        ], 200);
    }
}
