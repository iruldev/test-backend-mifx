<?php


namespace App\Repositories;

use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Support\Facades\DB;

class BookRepository
{
    /**
     * @var Book
     */
    private $model;

    /**
     * @var BookAuthor
    */
    private $bookAuthor;

    /**
     * BookRepository constructor
     * @param Book $model
     * @param BookAuthor $bookAuthor
     */
    public function __construct(Book $model, BookAuthor $bookAuthor)
    {
        $this->model = $model;
        $this->bookAuthor = $bookAuthor;
    }

    /**
     * Store a new record
     *
     * @param array $input
     * @return object
     */
    public function store(array $input)
    {
        $book = $this->model->create($input);
        foreach ($input['authors'] as $author_id) {
            $this->bookAuthor->create(['book_id' => $book->id, 'author_id' => $author_id]);
        }
        return $book;
    }

    /**
     * Get all resource
     *
     * @param array $filters
     * @return object
     */
    public function getAll(array $filters = [])
    {
        $sortColumn = 'id';
        $sortDirection = 'ASC';
        if ( isset($filters['sortColumn']) && in_array($filters['sortColumn'], ['title', 'published_year', 'avg_review']) ) {
            $sortColumn = $filters['sortColumn'];
        }
        if ( isset($filters['sortDirection']) && in_array($filters['sortDirection'], ['DESC', 'ASC']) ) {
            $sortDirection = $filters['sortDirection'];
        }
        return $this->model
            ->select(
                'books.*',
                DB::raw('COUNT(book_reviews.id) as count_review'),
                DB::raw('ROUND(AVG(book_reviews.review)) as avg_review'),
            )
            ->leftJoin('book_reviews', 'book_reviews.book_id', 'books.id')
            ->where(function ($query) use ($filters, $sortColumn, $sortDirection) {
                // Filter title
                if ( isset($filters['title']) && !empty($filters['title']) ) {
                    $query->where('title', 'LIKE', '%'.$filters['title'].'%');
                }
                // Filter authors
                if ( isset($filters['authors']) && !empty($filters['authors']) ) {
                    $query->whereHas('authors', function ($query) use ($filters) {
                        $query->whereIn('id', explode(',', $filters['authors']));
                    });
                }
            })
            ->with('authors')
            ->groupBy('books.id')
            ->orderBy($sortColumn, $sortDirection)
            ->paginate();
    }

    /**
     * Get resource by ID
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getById(int $id)
    {
        return $this->model
            ->with('authors', 'reviews')
            ->findOrFail($id);
    }
}
