<?php
declare (strict_types=1);

namespace app\model;

use think\Model;
use app\traits\ModelTrait;

/**
 * 文章
 * Class Article
 * @package app\model
 * @author  kyangs@163.com
 */
class Article extends Model
{
    //时间字段显示格式
    protected $dateFormat = 'Y-m-d H:i:s';
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //只读字段，不允许被更改
    protected $readonly = [];
    //数据输出隐藏的属性
    protected $hidden = [];

    //据输出显示的属性
    public static $showField = [
        'id', 'title', 'content',
        'status', 'sorts', 'cate_id',
        'column_id', 'img', 'update_time',
        'create_time','image_key',
    ];

    //查询类型转换, 与Model 中的type类型转化功能相同，只是新增字符串类型
    protected $selectType = [
        'id'        => 'string',
        'column_id' => 'string',
        'cate_id'   => 'string',
    ];

    use ModelTrait;
}
