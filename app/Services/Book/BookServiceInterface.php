<?php

namespace App\Services\Book;

use App\Book;
use App\BookReview;

interface BookServiceInterface
{
    /**
     * @param int $page
     * @param array $sort
     * @param array $search
     *
     * @return array
     */
    public function getCollection(int $page, array $sort, array $search): array;

    /**
     * @param array $fields
     *
     * @return Book
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function insertBook(array $fields): Book;

    /**
     * @param Book $book
     * @param array $fields
     *
     * @return BookReview
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function insertPostReview(Book $book, array $fields): BookReview;
}
