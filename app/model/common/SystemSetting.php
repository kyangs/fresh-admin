<?php


namespace app\model\common;


use app\controller\admin\Upload;
use app\service\UploadService;
use app\traits\ModelTrait;
use think\Model;

class SystemSetting extends Model
{
    protected $table = 'system_setting';
    use ModelTrait;

    /**
     * @param $key
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getSettingByKey($key)
    {
        $row = self::where('unique_key', $key)->find();
        return empty($row) ? [] : $row->toArray();
    }

    public static function uploadSettingMapping(){
        $row = self::where('unique_key', 'upload')->find();
        if (empty($row)) return [];

        $array = json_decode($row['value'],true);

        foreach ($array as &$item) {

           if (isset($item['http'])){
               $item['http'] = rtrim($item['http'],'/').'/';
           }
        }
        return $array;
    }

    public static function defaultUploadSetting()
    {
        $row = self::getSettingByKey('upload');
        if (empty($row)) {
            return [];
        }
        $row = json_decode($row['value'],true);
        return isset($row[$row['default']]) ? $row[$row['default']] : [];
    }

    public static function saveSetting($key, $value, $describe = '')
    {
        $row  = self::getSettingByKey($key);
        $data = [
            'unique_key' => $key,
            'value'      => is_string($value) ? $value : json_encode($value),
            'intro'      => $describe,
        ];
        if (!empty($row)) {

            return self::update($data, ['unique_key' => $key]);
        }

        return self::create($data);
    }

}
