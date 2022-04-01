<?php

namespace App\Http\Resources\Interfaces;

use Illuminate\Http\Resources\Json\JsonResource;

interface UserResourceInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;
}
