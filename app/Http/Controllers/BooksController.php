<?php

declare (strict_types=1);

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\PostBookRequest;
use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookReviewResource;
use App\Services\Book\BookServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BooksController extends Controller
{
    /**
     * @param Request $request
     * @param BookServiceInterface $bookService
     *
     * @return JsonResource
     */
    public function getCollection(Request $request, BookServiceInterface $bookService): JsonResource
    {
        $page = (int) $request->get('page') ?? 1;

        $sort = [
            'sortColumn' => $request->get('sortColumn'),
            'sortDirection' => $request->get('sortDirection'),
        ];

        $search = [
            'title' => $request->get('title'),
            'authors' => $request->get('authors'),
        ];

        $books = $bookService->getCollection($page, $sort, $search);

        return BookResource::collection($books['items'])->additional([
            'links' => [
                'first' => '',
                'last' => '',
                'prev' => '',
                'next' => '',
            ],
            'meta' => [
                'current_page' => '',
                'from' => '',
                'last_page' => '',
                'path' => '',
                'per_page' => '',
                'to' => '',
                'total' => '',
            ]
        ]);
    }

    /**
     * @param PostBookRequest $request
     * @param BookServiceInterface $bookService
     *
     * @return JsonResource
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function post(PostBookRequest $request, BookServiceInterface $bookService): JsonResource
    {
        $book = $bookService->insertBook($request->only([
            'isbn',
            'title',
            'description',
            'authors',
        ]));

        return new BookResource($book);
    }

    /**
     * @param Book $book
     * @param PostBookReviewRequest $request
     * @param BookServiceInterface $bookService
     *
     * @return JsonResource
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function postReview(Book $book, PostBookReviewRequest $request, BookServiceInterface $bookService): JsonResource
    {
        $user = \auth()->user();

        $fields = [
            'review' => $request->get('review'),
            'comment' => $request->get('comment'),
            'user' => $user
        ];

        $bookReview = $bookService->insertPostReview($book, $fields);

        return new BookReviewResource($bookReview);
    }
}
