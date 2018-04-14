<?php
/**
 * Created by PhpStorm.
 * User: coco
 * Date: 2018/4/15
 * Time: 上午12:38
 */
use Spatie\Permission\Models\Permission;

return [
    'title' => '权限',
    'single' => '权限',
    'model' => Permission::class,

    'permission' => function(){
        return Auth::user()->can('manage_users');
    },

    // 对 CRUD 动作的单独权限控制，通过返回布尔值来控制权限。
    'action_permissions' => [
        // 控制『新建按钮』的显示
        'create' => function($model){
            return true;
        },
        // 允许更新
        'update' => function($model){
            return true;
        },
        // 不允许删除
        'delete' => function($model){
            return false;
        },
        'view' => function($model){
            return true;
        }
        // 允许查看
    ],
    'columns' => [
        'id' => [
            'title' => 'ID',
        ],
        'name' => [
            'title' => '标识',
        ],
        'operation' => [
            'title' => '管理',
            'sortable' => false,
        ],
    ],
    'edit_fields' => [
        'name' => [
            'title' => '标识',

            // 表单条目标题旁的『提示信息』
            'hint' => '修改权限标识会影响代码的调用，请不要轻易更改。',
        ],
        'roles' => [
            'title' => '角色',
            'type' => 'relationship',
            'name_field' => 'name',
        ],
    ],
    'filters' => [
        'name' => [
            'title' => '标识',
        ],
    ],
];