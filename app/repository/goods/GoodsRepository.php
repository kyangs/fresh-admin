<?php
declare (strict_types=1);

namespace app\repository\goods;

use app\model\common\Goods;
use app\repository\file\FileSystemRepository;
use app\traits\RepositoryTrait;

/**
 * 应用
 * Class GoodsRepository
 * @package app\repository\goods
 * @author  kyangs@163.com
 */
class GoodsRepository
{

    //模型，带命名空间
    public static $model = 'app\model\Goods';
    //模型主键
    public static $pk = 'id';
    //name字段名称
    public static $name = 'appid';

    use RepositoryTrait;


    public static function findByGoodsID($goodsIdList, $orderArray = ['create_time', 'desc'],$idAsKey=false)
    {
        $goods = new Goods;
        list($field, $order) = $orderArray;
        $goodsList = $goods->whereIn('id', $goodsIdList)
            ->order($field, $order)->select();
        if (empty($goodsList)) return [];
        $goodsList = $goodsList->toArray();

        $goodsListAsIdKey = [];
        $goodsImage       = FileSystemRepository::findByIds(array_column($goodsList, 'main_image'), true);
        foreach ($goodsList as &$item) {
            $item['main_image_url'] = isset($goodsImage[$item['main_image']]) ? $goodsImage[$item['main_image']] : '';
            $item['self_sale']      = empty($item['store_id']) ? '自营' : '';
            $goodsListAsIdKey[$item['id']] = $item;
        }
        return $idAsKey ? $goodsListAsIdKey : $goodsList;
    }

}
