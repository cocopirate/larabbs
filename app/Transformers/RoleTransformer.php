<?php
/**
 * Created by PhpStorm.
 * User: coco
 * Date: 2018/5/6
 * Time: 下午12:07
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
        ];
    }

}