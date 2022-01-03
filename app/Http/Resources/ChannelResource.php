<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => (int) $this->id,
            'name' => (string) $this->name,
            'icon' => (string) $this->icon,
            'updated_at' => (string) $this->updated_at,
            'created_at' => (string) $this->created_at,
        ];
    }
}
