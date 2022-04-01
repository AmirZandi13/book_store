<?php

declare (strict_types=1);


namespace App\Http\Resources;


use App\Http\Resources\Interfaces\BookResourceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource implements BookResourceInterface
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
            'isbn' => $this->getIsbn(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'authors' => $this->getAuthors(),
            'review' => $this->getReview(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->resource['id'];
    }

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return (string) $this->resource->isbn;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->resource->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->resource->description;
    }

    /**
     * @return array
     */
    public function getAuthors(): array
    {
        return $this->resource->authors->toArray();
    }

    /**
     * @return int[]
     */
    public function getReview(): array
    {
        $reviews = $this->resource->reviews;
        return [
            'avg' => (int) round($reviews->avg('review') ?? 0),
            'count' => (int) $reviews->count(),
        ];
    }
}
