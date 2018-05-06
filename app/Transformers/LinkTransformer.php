<?php
/**
 * Created by PhpStorm.
 * User: coco
 * Date: 2018/5/6
 * Time: 下午12:24
 */

namespace App\Transformers;


use App\Models\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    public function transform(Link $link)
    {
        return [
            'id' => $link->id,
            'title' => $link->title,
            'link' => $link->link,
        ];

    }
}