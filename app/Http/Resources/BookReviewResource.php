<?php

declare (strict_types=1);


namespace App\Http\Resources;


use App\Http\Resources\Interfaces\BookReviewResourceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class BookReviewResource extends JsonResource implements BookReviewResourceInterface
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
            'review' => $this->getReview(),
            'comment' => $this->getComment(),
            'user' => $this->getUser(),
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
     * @return int
     */
    public function getReview(): int
    {
        return $this->resource->review;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->resource->comment;
    }

    /**
     * @return JsonResource
     */
    public function getUser(): JsonResource
    {
        return new UserResource($this->resource->user);
    }
}
