<?php

namespace App\Http\Requests\Api;


class ReplyRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reply_content' => 'required|min:2'
        ];
    }
}
