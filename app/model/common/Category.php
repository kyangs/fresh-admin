<?php


namespace app\model\common;


use app\traits\ModelTrait;
use think\Model;

class Category extends Model
{
    protected $table = 'category';
    use ModelTrait;
}