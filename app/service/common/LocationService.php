<?php


namespace app\service\common;


use app\model\common\SystemSetting;
use app\repository\system\SystemSettingRepository;
use app\service\BaseService;
use utils\Utils;

class LocationService extends BaseService
{


    /** 获取 地理位置
     * @param $request
     * // result => "location": {
     * //            "lng": 121.14288949565618,
     * //            "lat": 31.287049838930515
     * //        },
     * //        "formatted_address": "江苏省苏州市昆山市绿地大道辅路",
     * //        "business": "",
     * //        "addressComponent": {
     * //            "country": "中国",
     * //            "country_code": 0,
     * //            "country_code_iso": "CHN",
     * //            "country_code_iso2": "CN",
     * //            "province": "江苏省",
     * //            "city": "苏州市",
     * //            "city_level": 2,
     * //            "district": "昆山市",
     * //            "town": "",
     * //            "town_code": "",
     * //            "adcode": "320583",
     * //            "street": "绿地大道辅路",
     * //            "street_number": "",
     * //            "direction": "",
     * //            "distance": ""
     * //        },
     * //        "pois": [],
     * //        "roads": [],
     * //        "poiRegions": [],
     * //        "sematic_description": "",
     * //        "cityCode": 224
     * //    }
     * @return string[]
     */
    public static function location($request)
    {
        $setVal = SystemSettingRepository::setting(SystemSetting::SETTING_MAP);
        $res    = Utils::getRequest($setVal['url'], [
            'key'        => $setVal['key'],
            'output'     => 'json',
            'radius'     => '500',
            'extensions' => 'all',
            'location'   => $request->longitude . ',' . $request->latitude,
        ]);
        return [
            'location' => !empty($res) && isset($res->regeocode) ? $res->regeocode : '',
        ];
    }
}