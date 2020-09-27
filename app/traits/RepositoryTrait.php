<?php
declare (strict_types=1);

namespace app\traits;

/**
 * 数据仓库公共方法
 * Trait RepositoryTrait
 * @package app\traits
 */
trait RepositoryTrait
{

    /**
     * 通过ID获取信息
     * @param $id
     * @param $field 获取字段
     * @param $where 附加条件
     * @return mixed
     */
    public static function getInfoById($id, $field = [], $where = true)
    {
        return self::$model::where([self::$pk => $id])->where($where)->field($field ?: self::$model::$showField)->find();
    }

    /**
     * 通过name获取信息
     * @param $name
     * @param $field 获取字段
     * @param $where 附加条件
     * @return mixed
     */
    public static function getInfoByName($name, $field = [], $where = true)
    {
        return self::$model::where([self::$name => $name])->where($where)->field($field ?: self::$model::$showField)->find();
    }

    /**
     * 获取列表,分頁
     * @param bool $where 查询条件
     * @param array $myorder 排序
     * @param int $page 页码
     * @param int $psize 分页大小
     * @param array $field 获取字段
     * @return mixed
     */
    public static function getLists($where, $myorder, $page = 1, $psize = 20, $field = [])
    {
        return self::$model::where($where)->order($myorder)->page($page, $psize)->field($field ?: self::$model::$showField)->select();
    }

    /**
     * 获取全部列表
     * @param array $where 查询条件
     * @param array $order 排序
     * @param array $field 获取字段
     * @return mixed
     */
    public static function getListsAll($where, $order, $field = [])
    {
        $_this = self::$model::where($where)->field($field ?: self::$model::$showField);
        if (!empty($order)){
            $_this = $_this->order($order);
        }

        return $_this->select();
    }

    /**
     * 查询数量
     * @param bool $where 查询条件
     * @return mixed
     */
    public static function getTotal($where)
    {
        return self::$model::where($where)->count();
    }

    /**
     * 新增
     * @param $data
     */
    public static function add($data)
    {
        return self::$model::create($data);
    }

    /**
     * 修改
     * @param $id
     * @param $data
     */
    public static function edit($id, $data)
    {
        return self::$model::update($data, [self::$pk => $id]);
    }

    /**
     * 删除
     * @param int/array $id
     * @return int
     */
    public static function del($id)
    {
        return self::$model::destroy($id);
    }

    /**
     * 删除
     * @param $account
     * @param $phone
     * @return object
     */
    public static function getByAccountOrPhone($account, $phone)
    {
        return self::$model::where([
            'account' => $account,
        ])->whereOr([
            'phone' => $phone,
        ])->find();
    }


    public static function paginate($where, $order, $page = 1, $pageSize = 20, $field = [], $toArray = true)
    {
        $page = self::getLists($where, $order, $page, $pageSize, $field);
        return [
            'data'  => $toArray ? $page->toArray() : $page,
            'total' => self::getTotal($where),
        ];
    }

}
