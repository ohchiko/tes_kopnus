<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostingResource extends JsonResource
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
            "client" => $this->client->toResource(),
            "title" => $this->title,
            "description" => $this->description,
            "salary" => $this->salary,
            "is_published" => isset($this->published_at),
            "published_at" => $this->published_at
        ];
    }
}
