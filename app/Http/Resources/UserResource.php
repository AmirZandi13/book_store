<?php

declare (strict_types=1);


namespace App\Http\Resources;


use App\Http\Resources\Interfaces\UserResourceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource implements UserResourceInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->resource->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->resource->name;
    }
}
