<?php


namespace App\Services;

use App\Http\Resources\BookReviewResource;
use App\Repositories\BookReviewRepository;

class BookReviewService
{
    /**
     * @var BookReviewRepository
     */
    private $bookReviewRepository;

    /**
     * BookService constructor
     * @param BookReviewRepository $bookReviewRepository
     */
    public function __construct(BookReviewRepository $bookReviewRepository)
    {
        $this->bookReviewRepository = $bookReviewRepository;
    }

    /**
     * Store a new record
     *
     * @param array $input
     * @return BookReviewRepository
     */
    public function store(array $input)
    {
        $reviewId = $this->bookReviewRepository->store($input)->id;
        return $this->getById($reviewId);
    }


    /**
     * Get resource by ID
     *
     * @param int $id
     * @return BookReviewResource
     */
    public function getById(int $id)
    {
        return new BookReviewResource($this->bookReviewRepository->getById($id));
    }

    /**
     * Delete specific resource
     *
     * @param int $bookId
     * @param int $reviewId
     * @return bool
     */
    public function destroy(int $bookId, int $reviewId)
    {
        return $this->bookReviewRepository->destroy($bookId, $reviewId);
    }
}
