<?php


namespace App\Services;

use App\Http\Resources\BookResource;
use App\Repositories\BookRepository;

class BookService
{
    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * BookService constructor
     * @param BookRepository $bookRepository
     */
    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Store a new record
     *
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function store(array $input)
    {
        $bookId = $this->bookRepository->store($input)->id;
        return $this->getById($bookId);
    }

    /**
     * Get all resource
     *
     * @param array $filters
     * @return BookResource
     */
    public function getAll(array $filters = [])
    {
        return new BookResource( $this->bookRepository->getAll($filters) );
    }

    /**
     * Get resource by ID
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getById(int $id)
    {
        return $this->bookRepository->getById($id);
    }
}
