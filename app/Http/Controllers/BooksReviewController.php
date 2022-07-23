<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookReviewResource;
use Illuminate\Support\Facades\Auth;
use App\Traits\apiJsonReturnTrait;
use Illuminate\Http\Request;

// Services
use App\Services\BookService;
use App\Services\BookReviewService;

class BooksReviewController extends Controller
{
    use apiJsonReturnTrait;

    /**
     * @var BookService
     */
    private $bookService;

    /**
     * @var BookReviewService
     */
    private $bookReviewService;

    /**
     * BooksReviewController constructor
     * @param BookService $bookService
     * @param BookReviewService $bookReviewService
     */
    public function __construct(BookService $bookService, BookReviewService $bookReviewService)
    {
        $this->bookService = $bookService;
        $this->bookReviewService = $bookReviewService;
    }

    /**
     * Store a new record
     *
     * @param int $bookId
     * @param PostBookReviewRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(int $bookId, PostBookReviewRequest $request)
    {
        // @TODO implement
        $this->bookService->getById($bookId);

        $request->offsetSet('user_id', Auth::user()->id);
        $request->offsetSet('book_id', $bookId);

        $review = $this->bookReviewService->store($request->all());
        $result = [
            'id' => $review->id,
            'review' => $review->review,
            'comment' => $review->comment,
            'user' => [
                'id' => $review->user->id,
                'name' => $review->user->name,
            ],
        ];
        return $this->returnJson($result, 'Success create new record', '201');
    }

    /**
     * Delete specific resource
     *
     * @param int $bookId
     * @param int $reviewId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        $this->bookService->getById($bookId);
        $this->bookReviewService->getById($reviewId);

        $this->bookReviewService->destroy($bookId, $reviewId);

        return $this->returnJson([], 'Success deleted', '204');
    }
}
