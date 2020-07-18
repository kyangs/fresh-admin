<?php


namespace app\service\common;


use app\model\common\Category;
use app\model\common\File;
use app\model\common\FileGroup;
use app\model\common\Goods;
use app\model\common\GoodsDetailIntroImage;
use app\model\common\GoodsImage;
use app\model\common\GoodsTag;
use app\service\BaseService;
use app\service\UploadService;

class GoodsService extends BaseService
{

    /**store_id       bigint(20) comment '店铺ID'      default 0,
     * `goods_name`   char(200)                      DEFAULT '' COMMENT '名称',
     * `short_desc`   char(200)                      DEFAULT '' COMMENT '简短描述',
     * `is_enabled`   tinyint(1)                     DEFAULT '1' COMMENT '为1正常，为0下回架',
     * `detail`       text COMMENT '商品详情',
     * `sort`         int COMMENT '商品排序'             default 100,
     * `stock`        int COMMENT '商品库存'             default 0,
     * sale           bigint(20) comment '商品销量'      default 0,
     * warning_num    int(11) comment '商品预警量'        default 1,
     * weight         int(11) comment '商品预重量单位g'     default 0,
     * `origin_price` decimal(10, 2) COMMENT '商品原价'  default 0.00,
     * `price`        decimal(10, 2) COMMENT '商品当前价' default 0.00,
     * `main_image`   bigint(20) COMMENT '商品主图ID'    default 0,
     * `cate_id`      bigint(20) COMMENT '商品分类'      default 0,
     * @param $request
     */
    public static function saveGoods($request)
    {
        $data = [
            'store_id'     => 0,
            'goods_name'   => $request->goods_name,
            'short_desc'   => isset($request->short_desc) ? $request->short_desc : '',
            'is_enabled'   => $request->is_enabled,
            'detail'       => $request->detail,
            'price'        => $request->price,
            'main_image'   => $request->main_image_id,
            'weight'       => isset($request->weight) ? $request->weight : 0,
            'stock'        => $request->stock,
            'sort'         => $request->sort,
            'origin_price' => $request->origin_price,
            'cate_id'      => $request->child_cate_id ? $request->child_cate_id : $request->cate_id,
        ];
        if (isset($request->id) && !empty($request->id)) {
            Goods::update($data, ['id' => $request->id]);
        } else {
            $goods       = Goods::create($data);
            $request->id = $goods->id;
        }

        $imageList = $tagList = $introImageList = [];
        if ($request->tag_list) {
            foreach ($request->tag_list as $tag) {
                $tagList[] = [
                    'goods_id' => $request->id,
                    'name'     => $tag,
                ];
            }
        }
        if ($request->image_id_list) {
            foreach ($request->image_id_list as $cid) {
                $imageList[] = [
                    'goods_id' => $request->id,
                    'image_id' => $cid,
                ];
            }
        }
        if ($request->detail_images_id) {
            foreach ($request->detail_images_id as $did) {
                $introImageList[] = [
                    'goods_id' => $request->id,
                    'image_id' => $did,
                ];
            }
        }
        GoodsImage::deleteForSave($request->id, $imageList);
        GoodsDetailIntroImage::deleteForSave($request->id, $introImageList);
        GoodsTag::deleteForSave($request->id, $tagList);
    }


    public static function goodsList($request)
    {
        $otherImage = $introImage = $introResult = $detailResult = $tagList = $cateIdList = [];
        if (!isset($request->pageSize)) $request->pageSize = 50;
        if (isset($request->child_id) && empty($request->child_id)) {
            $parentCate = Category::categoryByParentID($request->cate_id);
            $cateIdList = array_column($parentCate, 'id');
            array_push($cateIdList, $request->cate_id);
        }
        $request->cate_id = !empty($request->child_id) ? [$request->child_id] : $cateIdList;
        $page             = Goods::goodsList($request);
        $goodsId          = array_column($page['data'], 'id');
        $imageIds         = array_column($page['data'], 'main_image');

        foreach (GoodsImage::findByGoodsIds($goodsId) as $item) {
            $introImage[$item['goods_id']][] = $item['image_id'];
            $imageIds[]                      = $item['image_id'];
        }

        foreach (GoodsDetailIntroImage::findByGoodsIds($goodsId) as $intro) {
            $otherImage[$intro['goods_id']][] = $intro['image_id'];
            $imageIds[]                       = $intro['image_id'];
        }
        $goodsImage = File::findByIds($imageIds, true);

        foreach ($introImage as $gid => $intros) {
            foreach ($intros as $imgID) {
                if (isset($goodsImage[$imgID])) $introResult[$gid][] = $goodsImage[$imgID];
            }
        }

        foreach ($otherImage as $gid => $other) {
            foreach ($other as $imgID) {
                if (isset($goodsImage[$imgID])) $detailResult[$gid][] = $goodsImage[$imgID];
            }
        }
        foreach (GoodsTag::findByGoodsIds($goodsId) as $item) $tagList[$item['goods_id']][] = $item['name'];

        foreach ($page['data'] as &$item) {
            $item['main_image_url'] = isset($goodsImage[$item['main_image']]) ? $goodsImage[$item['main_image']] : '';
            $item['carousel']       = isset($introResult[$item['id']]) ? $introResult[$item['id']] : [];
            $item['detail']         = isset($detailResult[$item['id']]) ? $detailResult[$item['id']] : [];
            $item['tag_list'] = isset($tagList[$item['id']]) ? $tagList[$item['id']] : [];
            $item['self_sale'] = empty($item['store_id']) ? '平台自营' : '';
        }
        return $page;
    }
}
