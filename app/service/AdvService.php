<?php
declare (strict_types=1);

namespace app\service;


use app\model\Adv;
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


    public function findAbleAdv()
    {
        $adv = (new Adv)->findAbleAdv($this->time());
        return $adv;
    }

    /**
     * @param $request
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function listByFilter($request)
    {
        $adv = new Adv;
        if (!empty($request->position)) {
            $adv = $adv->where('position', '=', $request->position);
        }
        if (!empty($request->time_range)) {
            list($start, $end) = $request->time_range;
            $adv = $adv->where('start_time', '>=', $start);
            $adv = $adv->where('end_time', '<=', $end);
        }
        if (!empty($request->username)) {
            $adv = $adv->where('username', 'like', '%' . $request->username . '%');
        }
        $list = $adv->select()->toArray();
        foreach ($list as &$item) {
            $item['full_path']  = UploadService::fullPath($item['image']);
            $item['is_enabled'] = strval($item['is_enabled']);
        }
        return $list;
    }

    public function saveAdv($request, $user)
    {
        list($start, $end) = $request->time_range ?: ['', ''];
        $data = [
            'position'   => $request->position,
            'image'      => $request->image,
            'link'       => $request->link,
            'start_time' => $start,
            'is_enabled' => $request->is_enabled,
            'end_time'   => $end,
            'sort'       => $request->sort,
            'username'   => $user->username,
        ];

        if (!empty($request->id)) {
            Adv::update($data, ['id' => $request->id]);
            return;
        }

        Adv::create($data);
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
}
