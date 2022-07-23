<?php


namespace App\Repositories;

use App\Models\BookReview;

class BookReviewRepository
{
    /**
     * @var BookReview
    */
    private $model;

    /**
     * BookReviewRepository constructor
     * @param BookReview $model
     */
    public function __construct(BookReview $model)
    {
        $this->model = $model;
    }

    /**
     * Store a new record
     *
     * @param array $input
     * @return object
     */
    public function store(array $input)
    {
        return $this->model->create($input);;
    }

    /**
     * Get resource by ID
     *
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        return $this->model
            ->with('user')
            ->findOrFail($id);
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
        return $this->model->where('book_id', $bookId)->where('id', $reviewId)->delete();
    }
}
