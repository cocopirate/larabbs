<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodesRequest;
use Cache;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodesRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;

        if(!app()->environment('production')){
            $code = '1234';
        } else {
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

            try{
                $result = $easySms->send($phone, [
                    'template' => 'SMS_132385787',
                    'data' => [
                        'code' => $code,
                    ],
                ]);

            } catch (ClientException $exception){
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['Message'] ? : '短信发送异常');
            }
        }

        $key = 'verificationCode_' . str_random(15);

        $expiredAt = now()->addMinutes(5);

        // 缓存验证码 10分钟过期。
        Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        return $this->response->array([

            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),

        ])->setStatusCode(201);

    }
}
