<?php

namespace App\Http\Resources\Interfaces;

use Illuminate\Http\Resources\Json\JsonResource;

interface BookReviewResourceInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return int
     */
    public function getReview(): int;

    /**
     * @return string
     */
    public function getComment(): string;

    /**
     * @return JsonResource
     */
    public function getUser(): JsonResource;
}
