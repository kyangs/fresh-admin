<?php
declare (strict_types=1);

namespace app\controller\admin\system;


use app\controller\admin\Base;
use app\service\common\SystemSettingService;
use app\traits\ControllerTrait;
use think\annotation\route\Middleware;
use think\annotation\route\Group;
use think\annotation\Route;
use app\middleware\CheckAdmin;
use app\util\TreeUtil;

/**
 * Setting管理
 * Class Setting
 * @package app\controller\admin
 * @author  kyangs@163.com
 * @Group("admin/system")
 * @Middleware({CheckAdmin::class})
 */
class Setting extends Base
{

    /**
     * 上传设置
     * @Route("upload/setting", method="POST")
     */
    public function uploadSetting()
    {
        try {

            return json_ok(SystemSettingService::saveSetting($this->params, 'upload'));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }

    /**
     *获取设置
     * @Route("setting", method="POST")
     */
    public function setting()
    {
        try {

            return json_ok(SystemSettingService::setting($this->params->key));
        } catch (\Exception $exception) {
            return json_error(10001, $exception->getMessage());
        }
    }
}
