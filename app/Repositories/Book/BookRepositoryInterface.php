<?php

namespace App\Repositories\Book;

interface BookRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return array
     */
    public function getCollection(array $params): array;
}
