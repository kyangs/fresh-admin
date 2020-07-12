<?php


namespace utils;


class Utils
{

    /** 发送GET请求
     * @param $url
     * @param $params
     * @return bool|string
     */
    public static function getRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }
}