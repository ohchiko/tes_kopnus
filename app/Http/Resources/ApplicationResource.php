<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "jobPosting" => $this->jobPosting->toResource(),
            "freelancer" => $this->freelancer->toResource(),
            "is_approved" => isset($this->approved_at),
            "approved_at" => $this->approved_at,
            "is_completed" => isset($this->completed_at),
            "completed_at" => $this->completed_at
        ];
    }
}
