<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Create a new class instance.
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
