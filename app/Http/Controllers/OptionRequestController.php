<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\PollResource;
use Validator;

class OptionRequestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Poll $poll)
    {
        if(count($request->get('options')) <= 0) 
            return \Response::json([
                'code' => 404,
                'message' => 'No valid data',
                'errors' => ''
            ], 404);

        $options = [];

        foreach ($request->get('options') as $key => $option) {
            if(!empty($option['option']) && $option['option'] != null) {
                $option['user_id'] = Auth::id();
                array_push($options, $option);
            }
        }
        if($poll->optionRequests()->createMany($options)) {
            return \Response::json([
                'code' => 201,
                'message' => 'created',
                'data' => new PollResource($poll)
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OptionRequest  $optionRequest
     * @return \Illuminate\Http\Response
     */
    public function show(OptionRequest $optionRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OptionRequest  $optionRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionRequest $optionRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OptionRequest  $optionRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionRequest $optionRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OptionRequest  $optionRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(OptionRequest $optionRequest)
    {
        //
    }
}
