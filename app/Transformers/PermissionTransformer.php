<?php
/**
 * Created by PhpStorm.
 * User: coco
 * Date: 2018/5/6
 * Time: 上午11:57
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
        ];
    }

}