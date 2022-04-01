<?php

namespace App\Repositories\Book;

use App\Book;
use App\Repositories\BaseRepository;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    /**
     * BookRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Book::class);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getCollection(array $params): array
    {
        return $this->getAll($params);
    }
}
