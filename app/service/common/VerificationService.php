<?php


namespace app\service\common;


use app\model\common\SystemSetting;
use app\repository\system\SystemSettingRepository;
use app\service\BaseService;
use think\helper\Str;
use utils\Utils;

class VerificationService extends BaseService
{
    const CODE_EXPIRE = 600;
    const CODE_RESEND = 60;

    /**
     * @param $post
     * @return array
     * @throws \Exception
     */
    public static function sendVerificationCode($post)
    {
        if (!isset($post['phone']) || empty($post['phone'])) {
            throw new \Exception('请输入手机号', 1);
        }
        $k   = $post['phone'];
        $tag = 'tag_' . $k;
        if (cache($tag)) {
            throw new \Exception('发送验证码过于频繁，请稍后重试', 1);
        }

        cache($k, null);
        $code = Str::random(6, 1);
        cache($k, $code, ['expire' => self::CODE_EXPIRE]);
        cache($tag, $k, ['expire' => self::CODE_RESEND]);
        return [
            'code' => $code,
        ];
    }
}
