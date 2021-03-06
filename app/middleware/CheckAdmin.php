<?php
declare (strict_types=1);

namespace app\middleware;

use app\util\JwtUtil;
use think\facade\Config;
use app\service\AdminService;

/**
 * 管理员身份验证
 * Class CheckAdmin
 * @package app\middleware
 * @author  kyangs@163.com
 */
class CheckAdmin
{
    public function handle($request, \Closure $next)
    {
        // JWT用户令牌认证，令牌内容获取
        $userToken = $request->header('x-access-token');
        if (empty($userToken)) {
            throw new \app\MyException(11101);
        }
        $userToken = think_decrypt($userToken);
        $payload   = JwtUtil::decode($userToken);
        if ($payload === false || empty($payload->aid) || empty($payload->login_time)) {
            throw new \app\MyException(11101);
        }
        //用户登录有效期
        $userLoginTime = Config::get('system.user_login_time');
        if ($payload->login_time < time() - $userLoginTime) {
            throw new \app\MyException(11102);
        }
        // 实时用户数据
        $user = AdminService::getInfoById($payload->aid);

        //用户是否存在
        if (empty($user)) {
            throw new \app\MyException(11104);
        }

        //是否多设备登录
        if (!empty($user['login_time']) && $user['login_time'] != $payload->login_time) {
            throw new \app\MyException(11103);
        }
        //认证：状态
        if ($user['is_enabled'] != true) {
            throw new \app\MyException(11106);
        }

        $request->sys_user = $user;
        return $next($request);
    }
}
