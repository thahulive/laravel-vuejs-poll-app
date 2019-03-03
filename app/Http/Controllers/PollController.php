<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Poll;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\PollResource;
use Validator;
class PollController extends Controller
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
        $polls = Poll::latest()->paginate(16);
        return PollResource::collection($polls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveOptions(Request $request, Poll $poll)
    {
        if(count($request->get('options')) <= 0) 
            return \Response::json([
                'code' => 404,
                'message' => 'No valid data',
                'errors' => ''
            ], 404);
        $options = [];
        foreach ($request->get('options') as $key => $option) {
            if(!empty($option['option']) && $option['option'] != null)
                array_push($options, $option);
        }
        if($poll->options()->createMany($options)) {
            return \Response::json([
                'code' => 201,
                'message' => 'created',
                'data' => new PollResource($poll)
            ], 201);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return \Response::json([
                'code' => 422,
                'message' => 'validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $poll = new Poll;
        $poll->title = $request->get('title');
        $poll->user_id = Auth::id();
        $poll->type = $request->get('mode') ? $request->get('mode') : 'single';
        $poll->description = $request->get('description') ? $request->get('description') : null;

        if($poll->save()) {
            return \Response::json([
                'code' => 201,
                'message' => 'created',
                'data' => new PollResource($poll)
            ], 201);
        }

        return \Response::json([
            'code' => 404,
            'errors' => 'unknown',
            'message' => "something wen't wrong"
        ], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Poll $poll)
    {
        return new PollResource($poll);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function vote(Request $request, Poll $poll)
    {
        try {
            foreach ($request->get('votes') as $key => $vote) {
                Vote::create($vote);
            }
        } catch (\Throwable $th) {
            return \Response::json([
                'code' => 500,
                'errors' => 'unknown',
                'message' => $th->getMessage(),
            ], 500);
        }
        
        return new PollResource($poll);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poll $poll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        //
    }
}
