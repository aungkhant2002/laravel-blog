<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
        return [
            "title" => "required|min:3|unique:posts,title",
            "category" => "required|integer|exists:categories,id",
            "description" => "required|min:5",
            "photo" => "nullable",
            "photo.*" => "file|mimetypes:image/jpeg,image/png",
            "tags" => "required",
            "tags.*" => "integer|exists:tags,id",
        ];
    }
}
