<?php


namespace app\service\common;


use app\model\common\Category;
use app\model\common\File;
use app\model\common\FileGroup;
use app\model\common\Goods;
use app\model\common\GoodsAttr;
use app\model\common\GoodsDetailIntroImage;
use app\model\common\GoodsImage;
use app\model\common\GoodsSales;
use app\model\common\GoodsTag;
use app\repository\file\FileSystemRepository;
use app\service\BaseService;
use app\service\UploadService;
use think\facade\Db;

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
        $imageList = $introImageList = $attrList = [];
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
        if (isset($request->attr_list) && !empty($request->attr_list)) {
            foreach ($request->attr_list as $attr) {
                $attrList[] = [
                    'goods_id'   => $request->id,
                    'attr_name'  => $attr->attr_name,
                    'attr_value' => $attr->attr_value,
                ];
            }
        }
        GoodsImage::deleteForSave($request->id, $imageList);
        GoodsDetailIntroImage::deleteForSave($request->id, $introImageList);
        GoodsAttr::deleteForSave($request->id, $attrList);
    }


    /** api 获取商品列表
     * @param $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function goodsList($request)
    {
        $cateIdList = [];
        if (!isset($request->pageSize)) $request->pageSize = 50;
        if (isset($request->child_id) && empty($request->child_id)) {
            $parentCate = Category::categoryByParentID($request->cate_id);
            $cateIdList = array_column($parentCate, 'id');
            array_push($cateIdList, $request->cate_id);
        }
        $request->cate_id = !empty($request->child_id) ? [$request->child_id] : $cateIdList;
        $page             = Goods::goodsList($request);
        $goodsImage       = FileSystemRepository::findByIds(array_column($page['data'], 'main_image'), true);
        foreach ($page['data'] as &$item) {
            $item['main_image_url'] = isset($goodsImage[$item['main_image']]) ? $goodsImage[$item['main_image']] : '';
            $item['carousel']       = isset($introResult[$item['id']]) ? $introResult[$item['id']] : [];
            $item['detail']         = isset($detailResult[$item['id']]) ? $detailResult[$item['id']] : [];
            $item['tag_list']       = [];
            $item['self_sale']      = empty($item['store_id']) ? '平台自营' : '';
        }
        return $page;
    }

    /** 获取商品详情
     * @param $goodsId
     */
    public static function goodsInfo($goodsId)
    {
        $goods = Goods::goodsInfoByID($goodsId);
        if (empty($goods)) throw new \Exception('商品不存在或已经下架', 1);

        $carouselImageIds = [];
        foreach (GoodsImage::findByGoodsId($goods['id']) as $item) $carouselImageIds[] = $item['image_id'];
        $carouselImage = FileSystemRepository::findByIds($carouselImageIds);

        $detailImageIds = [];
        foreach (GoodsDetailIntroImage::findByGoodsId($goods['id']) as $intro) $detailImageIds[] = $intro['image_id'];
        $detailImage = FileSystemRepository::findByIds($detailImageIds);
        $tagList     = GoodsTag::findByGoodsId($goods['id']);

        $cateRow = Category::categoryByID($goods['cate_id']);

        if (!empty($cateRow)) {
            if ($cateRow['parent_id'] != 0) {
                $goods['child_cate_id'] = $cateRow['id'];
                $goods['cate_id']       = $cateRow['parent_id'];
            }
        }
        $goods['carousel_image']   = array_column($carouselImage, 'full_url');
        $goods['detail_image']     = array_column($detailImage, 'full_url');
        $goods['attr_list']        = GoodsAttr::findByGoodsId($goods['id']);
        $goods['main_image_id']    = $goods['main_image'];
        $goods['main_image']       = FileSystemRepository::findById($goods['main_image'], true);
        $goods['image_id_list']    = $carouselImageIds;
        $goods['detail_images_id'] = $detailImageIds;
        $goods['detail_images']    = array_values($detailImage);
        $goods['image_list']       = array_values($carouselImage);
        $goods['mouth_sale']       = GoodsSales::getMothSalesByGoodsID($goods['id']);
        $goods['tag_list']         = array_column($tagList, 'name');
        return $goods;
    }

    public static function enabled($request)
    {
        return Goods::enabled($request->id, $request->is_enabled);
    }

    public static function delete($request)
    {
        return Goods::deleteById($request->id);
    }
}
