<?php

namespace App\Http\Requests;

class TextLessonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string',
        ];
    }
}
