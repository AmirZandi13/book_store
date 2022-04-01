<?php

namespace App\Http\Resources\Interfaces;

interface BookResourceInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return int
     */
    public function getIsbn(): string;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return array
     */
    public function getAuthors(): array;

    /**
     * @return array
     */
    public function getReview(): array;
}
