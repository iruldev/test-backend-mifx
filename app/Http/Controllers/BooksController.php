<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use App\Traits\apiJsonReturnTrait;
use Illuminate\Http\Request;

// Services
use App\Services\BookService;

class BooksController extends Controller
{
    use apiJsonReturnTrait;

    /**
     * @var BookService
    */
    private $bookService;

    /**
     * BooksController constructor
     * @param BookService $bookService
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Get all resource
     * @param Request $request
     * @return BookResource
     */
    public function index(Request $request)
    {
        // @TODO implement
        return $this->bookService->getAll($request->all());
    }

    /**
     * Store a new record
     *
     * @param PostBookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $book = $this->bookService->store($request->all());
        $result = [
            'id' => $book->id,
            'isbn' => $book->isbn,
            'title' => $book->title,
            'description' => $book->description,
            'authors' => $book->authors,
            'review' => [
                'avg' => round($book->reviews->avg('review')),
                'count' => $book->reviews->count(),
            ],
        ];
        return $this->returnJson($result, 'Success create new record', '201');
    }
}
