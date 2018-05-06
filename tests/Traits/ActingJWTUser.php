<?php
/**
 * Created by PhpStorm.
 * User: coco
 * Date: 2018/5/6
 * Time: 下午3:56
 */
namespace Tests\Traits;

use App\Models\User;

trait ActingJWTUser
{
    public function JWTActingAs(User $user)
    {
        $token = \Auth::guard('api')->fromUser($user);

        $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

        return $this;
    }
}