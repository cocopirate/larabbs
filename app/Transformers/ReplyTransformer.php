<?php
/**
 * Created by PhpStorm.
 * User: coco
 * Date: 2018/5/3
 * Time: 下午11:16
 */
namespace APP\Transformers;

use App\Models\Reply;
use League\Fractal\TransformerAbstract;

class ReplyTransformer extends TransformerAbstract
{
    public function transform(Reply $reply)
    {
        return [
            'id' => $reply->id,
            'user_id' => (int) $reply->user_id,
            'topic_id' => (int) $reply->topic_id,
            'content' => $reply->content,
            'created_at' => $reply->created_at->toDateTimeString(),
            'updated_at' => $reply->updated_at->toDateTimeString(),
        ];

    }
}