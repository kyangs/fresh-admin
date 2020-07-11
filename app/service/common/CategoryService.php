<?php


namespace app\service\common;


use app\model\common\Category;
use app\model\common\File;
use app\model\common\FileGroup;
use app\service\BaseService;
use app\service\UploadService;

class CategoryService extends BaseService
{

    /** 分类列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function listByFilter()
    {
        $parent = self::parentCategory();
        $child  = self::childCategory();
        foreach ($parent as &$p) {
            if (isset($child[$p['id']])) {
                $p['children'] = $child[$p['id']];
            }
        }
        return $parent;
    }

    /** 获取父类
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function parentCategory()
    {
        $res = Category::category();
        if (empty($res)) return $res;

        $images = File::findByIds(array_column($res, 'image_id'));

        foreach ($res as &$item) {
            $item['children'] = [];
            if (isset($images[$item['image_id']])) {
                $item['full_url'] = $images[$item['image_id']]['full_url'];
            }
        }

        return $res;
    }

    /** app 首页显示
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function showHomeAndEnable(){
        $res = Category::categoryByFilter([
            'parent_id'=>'0',
            'show_home'=>'1',
            'is_enabled'=>'1',
        ]);
        $images = File::findByIds(array_column($res, 'image_id'));
        foreach ($res as &$item) {
            $item['children'] = [];
            if (isset($images[$item['image_id']])) {
                $item['full_url'] = $images[$item['image_id']]['full_url'];
            }
        }
        return $res;
    }
    /** 子类列表，以父类id 为key
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function childCategory()
    {
        $res = Category::category(1);
        if (empty($res)) return $res;

        $images    = File::findByIds(array_column($res, 'image_id'));
        $childList = [];
        foreach ($res as $item) {

            if (isset($images[$item['image_id']])) {
                $item['full_url'] = $images[$item['image_id']]['full_url'];
            }
            $childList[$item['parent_id']][] = $item;
        }
        return $childList;
    }

    /**
     * @param $request
     * @param $user
     * name        varchar(50)      default ''                not null comment '分类名称',
     * parent_id   int(11) unsigned default 0                 not null comment '上级分类id',
     * image_id    int(11) unsigned default 0                 not null comment '分类图片id',
     * sort        int(11) unsigned default 0                 not null comment '排序方式(数字越小越靠前)',
     */
    public static function saveCategory($request, $user)
    {
        $data = [
            'name'       => $request->name,
            'parent_id'  => $request->parent_id,
            'image_id'   => $request->image_id,
            'sort'       => $request->sort,
            'show_home'  => $request->show_home,
            'is_enabled' => $request->is_enabled,
            'creator'    => $user['username'],
        ];
        if (isset($request->id) && !empty($request->id)) {

            return Category::update($data, ['id' => $request->id]);
        }
        return Category::create($data);
    }

    /**
     * @param $request
     */
    public static function enable($request)
    {
        return Category::update([
            'show_home'  => $request->show_home,
            'is_enabled' => $request->is_enabled,
        ], ['id' => $request->id]);
    }

    /**
     * @param $request
     */
    public static function deleteCategory($request)
    {
        return Category::deleteByIds([$request->id]);
    }
}
