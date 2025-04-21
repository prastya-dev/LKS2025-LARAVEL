<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\VersionResource;

class GamesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'created_by' => $this->author->username,
            'created_at' => $this->created_at,
            'updated_at' => $this->update_at,
            'TotalScore' => $this->score->count(),
            // // 'version' => VersionResource::collection($this->version),
        ];
    }
}
