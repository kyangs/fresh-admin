<?php
declare (strict_types=1);

namespace app\controller\admin;

use app\controller\admin\Base;
use app\service\AdvService;
use app\service\AuthGroupService;
use app\service\AuthRuleService;
use app\service\common\FileService;
use app\traits\ControllerTrait;
use think\annotation\route\Middleware;
use think\annotation\route\Group;
use think\annotation\Route;
use app\middleware\CheckAdmin;
use app\util\TreeUtil;
use app\model\Adv as AdvModel;

/**
 * 管理员管理
 * Class File
 * @package app\controller\admin
 * @author  kyangs@163.com
 * @Group("admin/file")
 * @Middleware({CheckAdmin::class})
 */
class File extends Base
{
    use ControllerTrait;

    /**
     * 获取信息
     * @Route("group-list", method="POST")
     * @throws \Exception
     */
    public function getList()
    {
        return json_ok((new FileService)->getGroup($this->params));
    }
    /**
     * 获取信息
     * @Route("list", method="POST")
     * @throws \Exception
     */
    public function getFileList()
    {
        return json_ok((new FileService)->getFileList($this->params));
    }

    /**
     * 新增组
     * @Route("group", method="POST")
     * @throws \Exception
     */
    public function group()
    {
        try {
            return json_ok((new FileService)->saveGroup($this->params));
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }
    /**
     * 删除组
     * @Route("group-delete", method="POST")
     * @throws \Exception
     */
    public function groupDelete()
    {
        try {
            return json_ok((new FileService)->deleteGroup($this->params));
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }
    /**
     * 删除文件
     * @Route("delete", method="POST")
     * @throws \Exception
     */
    public function deleteFile(){
        try {
            return json_ok((new FileService)->deleteFile($this->params));
        }catch (\Exception $exception){
            return json_error(10001,$exception->getMessage());
        }
    }

}
