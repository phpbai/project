<?php
namespace src;

/**
 * 数组工具类
 * Class ArrayTools
 * @package src
 */
class ArrayTools
{
    /**
     * 二维数组去重
     * @param $arr
     * @param $key
     * @return mixed
     */
    public function assocUnique($arr, $key)
    {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }

    /**
     * 二维数组排序
     * @param $arr (二维数组)
     * @param $key (要排序的键)
     * @return array {排序后的数据}
     */
    public function assocSort($arr,$key,$sort = SORT_DESC)
    {
        $result = array_column($arr,$key);
        array_multisort($result,$sort,$arr);
        return $arr;
    }

    /**
     * 二维数字统计
     * @param $arr (二维数组)
     * @param $key (要统计的键)
     * @param $val (要统计的值)
     * @return mixed
     */
    public function assocCount($arr,$key,$val)
    {
        if (!$arr) {
            return 0;
        }
        $result = array_column($arr,$key);//把值提取出来转成一维数组
        $result = array_count_values($result);//数组的值作为键名，该值在数组中出现的次数作为值
        return array_key_exists($val,$result) ? $result[$val] : 0;
    }

    /**
     * 计算二维数组某个值的合
     * @param $arr (二维数组)
     * @param $key (要统计的键)
     * @return int|mixed
     */
    public function assocSum($arr,  $key)
    {
        if (!$arr) {
            return 0;
        }
        $sum_no = 0;
        foreach($arr as $v)
        {
            $sum_no +=  $v[$key];
        }
        return $sum_no;
    }
}