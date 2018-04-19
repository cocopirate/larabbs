<?php
/**
 * Created by PhpStorm.
 * User: coco
 * Date: 2018/4/21
 * Time: 下午3:21
 */
namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
        ];
    }
}