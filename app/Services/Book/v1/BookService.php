<?php

namespace App\Services\Book\v1;

use App\Book;
use App\BookReview;
use App\Repositories\Book\BookRepositoryInterface;
use App\Services\Book\BookServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookService implements BookServiceInterface
{
    /**
     * @var BookRepositoryInterface
     */
    private $bookRepository;

    /**
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param int $page
     * @param array $sort
     * @param array $search
     *
     * @return array
     */
    public function getCollection(int $page, array $sort, array $search): array
    {
        $inputs = [];
        $wheres = [];

        $inputs['page'] = $page;

        if (isset($sort['sortColumn'])) {
            $inputs['orderBy'] = $sort['sortColumn'];
        }

        if (isset($sort['sortDirection'])) {
            $inputs['order'] = $sort['sortDirection'] == 'ASC' ? 'asc' : 'desc';
        }

        if (isset($search['title'])) {
            $wheres[] = [
                'method'	=>	'where',
                'args'		=> [
                    'title',
                    'like',
                    '%' . $search['title'] . '%'
                ]
            ];
        }

        if (isset($search['authors'])) {
            $authors = explode(',', $search['authors']);
            $wheres[] = [
                'method' => 'whereHas',
                'args' =>
                    [
                        'authors',
                        function($q) use ( $authors )
                        {
                            return $q->whereIn('id', $authors);
                        }
                    ],
            ];
        }

        $params = [
            'with' => ['authors', 'reviews'],
            'inputs' => $inputs,
            'wheres' => $wheres
        ];

        return $this->bookRepository->getCollection($params);
    }

    /**
     * @param array $fields
     *
     * @return Book
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function insertBook(array $fields): Book
    {
        DB::beginTransaction();

        try {
            $book = $this->bookRepository->create([
                'data' => [
                    'isbn' => $fields['isbn'],
                    'title' => $fields['title'],
                    'description' =>$fields['description']
                ]
            ]);

            $book->authors()->attach($fields['authors']);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error('something');
        }

        return $book ?? app()->make(Book::class);
    }

    /**
     * @param Book $book
     * @param array $fields
     *
     * @return BookReview
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function insertPostReview(Book $book, array $fields): BookReview
    {
        DB::beginTransaction();

        try {
            $bookReview = new BookReview();
            $bookReview->review = $fields['review'];
            $bookReview->comment = $fields['comment'];
            $bookReview->book()->associate($book);
            $bookReview->user()->associate($fields['user']);
            $book->reviews()->save($bookReview);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error('something');
        }

        return $bookReview ?? app()->make(BookReview::class);
    }
}
