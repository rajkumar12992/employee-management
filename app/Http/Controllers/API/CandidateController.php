<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\CommonController as CommonController;
use App\Http\Resources\Candidate as CandidateResource;
use App\Models\Candidate;
use Validator;

class CandidateController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if ($request->location) {
    		$candidates = Candidate::where('location',$request->location)->paginate(2);
    	}
        else {
        	$candidates = Candidate::paginate(2);
        }
    
        return $this->sendResponse(
        	CandidateResource::collection($candidates), 
        	'Data retrieved successfully.'
        );
    }

    /**
     * Display a listing of the resource with filtered data.
     *
     * @return \Illuminate\Http\Response
     */
    public function filerCandidates(Request $request)
    {

    	if ($request->name && $request->location) {
    		$candidates = Candidate::where('location',$request->location)
    			->where('name',$request->name)
    			->get();
    	}
    	else if ($request->name) {
    		$candidates = Candidate::where('name',$request->name)
    			->get();
    	}
    	else if ($request->location) {
    		$candidates = Candidate::where('location',$request->location)
    			->get();
    	}
        else {
        	$candidates = Candidate::all();
        }

        return $this->sendResponse(
        	CandidateResource::collection($candidates), 
        	'Data retrieved successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'description' => 'required',
            'phone_number' => 'required',
            'location' => 'required'            
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $candidate = Candidate::create($input);
   
        return $this->sendResponse(
        	new CandidateResource($candidate), 
        	'Candidate data created successfully.'
        );
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidate = Candidate::find($id);
  
        if (is_null($candidate)) {
            return $this->sendError('Candidate not found.');
        }
   
        return $this->sendResponse(
        	new CandidateResource($candidate), 
        	'Candidate data retrieved successfully.'
        );
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $candidate->name = $input['name'];
        $candidate->description = $input['detail'];
        $candidate->save();
   
        return $this->sendResponse(
        	new CandidateResource($candidate), 
        	'Candidate data updated successfully.'
        );
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$candidate = Candidate::find($id);
        
        if ($candidate) {
        	$candidate->delete();
   			return $this->sendResponse([], 'Candidate deleted successfully.');     	
        }
        else {
        	return $this->sendResponse([], 'Candidate not found.');
        }
   
    }
}
