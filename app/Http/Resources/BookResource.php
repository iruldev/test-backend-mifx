<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['data' =>
            $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'isbn' => $item->isbn,
                    'title' => $item->title,
                    'description' => $item->description,
                    'authors' => $item->authors,
                    'review' => [
                        'avg' => intval($item->avg_review),
                        'count' => intval($item->count_review),
                    ],
                ];
            })->toArray()
        ];
    }
}
