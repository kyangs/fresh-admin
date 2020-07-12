<?php


namespace app\service\common;


use app\model\common\Category;
use app\model\common\File;
use app\model\common\FileGroup;
use app\model\common\Notice;
use app\service\BaseService;
use app\service\UploadService;

class NoticeService extends BaseService
{

    /**
     * @param $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function listByFilter($request)
    {
        return Notice::listByFilter($request);
    }

    /**
     * @param $request
     * @return Notice
     * @throws \Exception
     */
    public static function enable($request)
    {
        if (empty($request->id)) throw new \Exception('参数错误', 1);
        return Notice::enable($request);
    }

    /**
     * @param $request
     * @param $user `username`    varchar(16)         NOT NULL DEFAULT '' COMMENT '创建者名',
     * `title`       varchar(100)        NOT NULL DEFAULT '' COMMENT '公告标题',
     * `tag`         varchar(10)         NOT NULL DEFAULT '' COMMENT '标签',
     * `content`     text                NULL COMMENT '公告内容',
     * `update_time` timestamp           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     * `is_enabled`  tinyint(1)          NOT NULL DEFAULT '1' COMMENT '用户状态  0 禁用，1正常',
     * `create_time` timestamp           NOT NULL DEFAULT CURRENT_TIMESTAMP,
     * `delete_time` timestamp           NULL     DEFAULT NULL,
     * `start_time`  timestamp           NULL     DEFAULT NULL,
     * `end_time`    timestamp           NULL     DEFAULT NULL,
     * `sort`        int(11)             NOT NULL DEFAULT '100' COMMENT '排序',
     */
    public static function saveNotice($request, $user)
    {
        if (empty($request->time_range)) throw new \Exception('请选择时间', 1);
        return Notice::saveNotice($request, $user);
    }

    /**
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public static function deleteNotice($request)
    {
        if (empty($request->id)) throw new \Exception('参数错误', 1);
        return Notice::deleteNotice($request);
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function enableList()
    {
        $request             = new \stdClass();
        $request->now_time   = self::time();
        $request->is_enabled = 1;
        return Notice::listByFilter($request);
    }
}
