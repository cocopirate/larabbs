<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\WeappAuthorizationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Http\Requests\Api\AuthorizationRequest;
use Auth;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;
use App\Traits\PassportToken;


class AuthorizationsController extends Controller
{
    use PassportToken;

    // 使用JWT登录
    /*
    public function store(AuthorizationRequest $request)
    {
        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username : $credentials['phone'] = $username;

        $credentials['password'] = $request->password;

        if(!$token = Auth::guard('api')->attempt($credentials)){
            return $this->response->errorUnauthorized(trans('auth.failed'));
        }

        return $this->respondWithToken($token)->setStatusCode(201);
    }
    */

    public function store(AuthorizationRequest $originRequest, AuthorizationServer $server, ServerRequestInterface $serverRequest)
    {
        try{
            return $server->respondToAccessTokenRequest($serverRequest, new Psr7Response)->withStatus(201);
        } catch (OAuthServerException $e){
            return $this->response->errorUnauthorized($e->getMessage());
        }
    }

    public function weappStore(WeappAuthorizationRequest $request)
    {
        $code = $request->code;

        // 根据 code 获取微信 openid 和 session_key
        $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($code);

        // 如果结果错误，说明 code 已过期或不正确，返回 401 错误
        if(isset($data['errcode'])){
            return $this->response->errorUnauthorized('code参数错误');
        }
        // 找到 openid 对应的用户
        $user = User::where('weapp_openid', $data['openid'])->first();

        $attributes['weixin_session_key'] = $data['session_key'];

        // 未找到对应用户则需要提交用户名密码进行用户绑定
        if(!$user){
            // 如果未提交用户名密码，403 错误提示

            if(!$request->username){
                return $this->response->errorForbidden('用户不存在');
            }

            $username = $request->username;

            // 用户名可以是邮箱或电话
            filter_var($username, FILTER_VALIDATE_EMAIL) ?
                $credentials['email'] = $username :
                $credentials['phone'] = $username;

            $credentials['password'] = $request->password;

            // 验证用户名和密码是否正确
            if(!auth()->attempt($credentials)){
                return $this->response->errorUnauthorized('用户名或密码错误');
            }

            // 获取用户
            $user = User::where('phone', $username)->orWhere('email', $username)->first();

            $attributes['weapp_openid'] = $data['openid'];
        }

        // 更新用户数据
        $user->update($attributes);

        $result = $this->getBearerTokenByUser($user, '1', false);
        return $this->response->array($result)->setStatusCode(201);
    }

    // 第三方社交平台登录
    public function socialStore($type, SocialAuthorizationRequest $request)
    {
        if(!in_array($type, ['weixin'])){
            return $this->response->errorBadRequest();
        }

        $driver = \Socialite::driver($type);

        try{
            if($code = $request->code) {
                $response = $driver->getAccessTokenResponse($code);
                $token = array_get($response, 'access_token');
            } else {
                $token = $request->access_token;

                if($type == 'weixin'){
                    $driver->setOpenId($request->openid);
                }
            }

            $oauthUser = $driver->userFromToken($token);

        } catch (\Exception $e) {

            return $this->response->errorUnauthorized('参数错误，未获取用户信息');
        }

        $user = null;

        switch ($type){

            case 'weixin':

                $unionid = $oauthUser->offsetExists('unionid') ? : null;

                if($unionid){
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if(!$user){
                    User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }

        $result = $this->getBearerTokenByUser($user, '1', false);
        return $this->response->array($result)->setStatusCode(201);

        // JWT的第三方登录token分配
        /*
        $token = Auth::guard('api')->fromUser($user);

        return $this->respondWithToken($token)->setStatusCode(201);
        */
    }


    public function update(AuthorizationServer $server, ServerRequestInterface $serverRequest)
    {
        try{
            return $server->respondToAccessTokenRequest($serverRequest, new Psr7Response);
        } catch (OAuthServerException $e){
            return $this->response->errorUnauthorized($e->getMessage());
        }
    }

    // 使用JWT刷新 Token
    /*
    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->respondWithToken($token);
    }
    */

    public function destroy()
    {
        $this->user()->token()->revoke();
        return $this->response->noContent();
    }

    // 使用JWT删除 Token
    /*
    public function destroy()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }
    */

    public function respondWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL()*60
        ]);
    }
}
