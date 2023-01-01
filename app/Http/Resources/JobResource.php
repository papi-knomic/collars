<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title"=> $this->title,
            "description" => $this->description,
            "user_id" => $this->user_id,
            "job_id" => $this->job_id,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "images" => $this->images,
            "slug" => $this->slug,
            "is_active" => $this->is_active,
            "budget" => $this->budget,
            "job_type" => new JobTypeResource($this->jobType),
            "job_offers" =>  JobOfferResource::collection( $this->whenLoaded('jobOffers'))
        ];
    }
}
