<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'reply_content' => 'required|min:2'
        ];
    }

    public function messages()
    {
        return [
            'reply_content.required' => '请输入回复内容'
        ];
    }
}
