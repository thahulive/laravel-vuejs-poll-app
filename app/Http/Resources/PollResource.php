<?php

namespace App\Http\Resources;
use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'options' => OptionResource::collection($this->options),
            'votes_count' => $this->votes()->count(),
            'isMyPoll' => (Auth::id() === $this->user_id) ? true : false,
            'my_votes_count' => $this->votes->where('user_id', Auth::id())->count(),
            'user' => new UserResource($this->user),
            'option_requests' => OptionRequestResource::collection($this->optionRequests)
        ];
    }
}
