<?php

namespace App\Http\Requests;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $authors = implode(',', Author::all()->pluck('id')->toArray());
        // @TODO implement
        return [
            'isbn'              => 'required|min:13|max:13|unique:books',
            'title'             => 'required',
            'description'       => 'required',
            'published_year'    => 'required|digits:4|integer|min:1900|max:2021',
            'authors'           => 'required|array',
            'authors.*'         => 'in:'.$authors,
        ];
    }
}
