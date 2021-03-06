<?php
declare (strict_types=1);

namespace app\service;


use app\model\Adv;
use app\repository\adv\AdvRepository;
use app\repository\file\FileSystemRepository;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 管理员
 * Class Advervice
 * @package app\service
 * @author  kyangs@163.com
 */
class AdvService extends BaseService
{
    /**
     * @param $request
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function listByFilter($request)
    {
        $data      = (new Adv)->listByFilter($request);
        $imageList = FileSystemRepository::findByIds(array_column($data, 'image_id'));
        foreach ($data as &$item) {
            $item['full_path'] = '';
            if (isset($imageList[$item['image_id']])) {
                $item['full_path'] = $imageList[$item['image_id']]['full_url'];
            }
            $item['is_enabled'] = strval($item['is_enabled']);
        }
        return $data;
    }

    /** 新增或保存广告
     * @param $request
     * @param $user
     * @return Adv|\think\Model
     * @throws \Exception
     */
    public function saveAdv($request, $user)
    {
        if (empty($request->position)) throw new \Exception('请选择位置！', 1);
        if (empty($request->image_id)) throw new \Exception('请选择图片！', 1);
        if (empty($request->time_range)) throw new \Exception('请选择时间范围！', 1);
        list($start, $end) = $request->time_range;
        $data = [
            'position'   => $request->position,
            'image_id'   => $request->image_id,
            'link'       => $request->link,
            'start_time' => $start,
            'is_enabled' => $request->is_enabled,
            'end_time'   => $end,
            'sort'       => $request->sort,
            'username'   => $user->username,
        ];

        if (!empty($request->id)) return Adv::update($data, ['id' => $request->id]);

        return Adv::create($data);
    }


    /**
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function deleteAdv($request)
    {

        if (empty($request->id)) throw new \Exception('参数错误', 1);

        return (new Adv)->where(['id' => $request->id])->delete();
    }


    /** 启用，禁用广告
     * @param $request
     * @return array
     * @throws \Exception
     */
    public function enable($request)
    {
        if (empty($request->id)) throw new \Exception('参数错误', 1);

        return [
            'is_enabled' => (new Adv)->enable($request->id, $request->is_enabled),
        ];
    }


    /**
     * @param $param
     * @return array|mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public static function advListByPosition($param)
    {
        if (!isset($param['position'])) {
            return [];
        }
        $position = is_array($param['position']) ? $param['position'] : explode(',', $param['position']);
        return AdvRepository::findAbleAdv(self::time(), $position);
    }
}
