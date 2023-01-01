<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class JobOfferResource extends JsonResource
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
            'id' => $this->id,
            'message' => $this->message,
            'status' => $this->status,
            "price" => $this->price,
            "job_id" => $this->job_id,
            "worker" => new WorkerResource( $this->worker ),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
