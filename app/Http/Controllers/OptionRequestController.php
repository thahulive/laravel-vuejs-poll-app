<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Poll;
use App\Models\Vote;
use App\Models\OptionRequest;
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
    public function approveOption(Request $request, Poll $poll)
    {
        try {
            $option = OptionRequest::find($request->get('option'));
        } catch (\Throwable $th) {
            //throw $th;
        }
     
        if($poll->options()->create([
            'option' => $option->option
        ])) {
            $option->delete();
            return \Response::json([
                'code' => 201,
                'message' => 'approved',
                'data' => new PollResource($poll)
            ], 201);
        }
    }
}
