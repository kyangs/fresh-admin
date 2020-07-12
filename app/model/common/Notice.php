<?php
declare (strict_types=1);

namespace app\model\common;

use think\Model;
use app\traits\ModelTrait;

/**
 * 管理员
 * Class Notice
 * @package app\model
 */
class Notice extends Model
{
    use ModelTrait;

    protected $table = 'notice';


    /**
     * @param $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function listByFilter($request)
    {
        $_this = new self;

        if (!empty($request->time_range)) {
            $_this = $_this->where('start_time', '>=', $request->time_range[0])
                ->where('end_time', '<=', $request->time_range[1]);
        }
        if (!empty($request->now_time)) {
            $_this = $_this->where('start_time', '<=', $request->now_time)
                ->where('end_time', '>=', $request->now_time);
        }
        if (!empty($request->username)) {
            $_this = $_this->where(['creator' => $request->username]);
        }
        if (isset($request->is_enabled)) {
            $_this = $_this->where(['is_enabled' => $request->is_enabled]);
        }
        return $_this->order('sort', 'asc')->select()->toArray();
    }

    public static function saveNotice($request, $user)
    {
        $data = [
            'title'      => $request->title,
            'tag'        => $request->tag,
            'content'    => $request->content,
            'is_enabled' => $request->is_enabled,
            'sort'       => $request->sort,
            'start_time' => $request->time_range[0],
            'end_time'   => $request->time_range[1],
            'creator'    => $user['username'],
        ];

        if (!empty($request->id)) {
            return self::update($data, ['id' => $request->id]);
        }
        return self::create($data);
    }


    public static function enable($request)
    {
        return self::update([
            'is_enabled' => $request->is_enabled,
        ], ['id' => $request->id]);
    }

    public static function deleteNotice($request)
    {
        return self::where(['id' => $request->id])->delete();
    }
}



