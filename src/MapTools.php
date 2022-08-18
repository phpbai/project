<?php
namespace src;

/**
 * 地图工具类
 * Class MapTools
 * @package src
 */
class MapTools
{
    /**
     * @desc 根据两个经纬度计算两地距离
     * @param $lat1 纬度1
     * @param $lng1 经度1
     * @param $lat2 纬度2
     * @param $lng2 经度2
     * @param int $len_type
     * @param int $decimal 1:m（米） or 2:km（千米）
     * @return float 两个距离保留几位小数点
     */
    public function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2) {

        $pi = pi(); // 圆周率
        $er = 6378.1369999999997;
        $radLat1 = ($lat1 * $pi) / 180;
        $radLat2 = ($lat2 * $pi) / 180;
        $a = $radLat1 - $radLat2;
        $b = (($lng1 * $pi) / 180) - (($lng2 * $pi) / 180);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + (cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))));
        $s = $s * $er;
        $s = round($s * 1000);
        if (1 < $len_type) {
            $s /= 1000;
        }
        return round($s, $decimal);

    }
}