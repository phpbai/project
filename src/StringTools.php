<?php
namespace src;

/**
 * 字符工具类
 * Class StringTools
 * @package src
 */
class StringTools
{
    /**
     * 产生随机字符串
     * @param int $length 指定长度
     * @return string
     */
    public function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    /**
     * 将一个字符串部分字符用*替代隐藏
     * @param  string  $string  待转换的字符串
     * @param  integer $bengin  起始位置，从0开始计数，当$type=4时，表示左侧保留长度
     * @param  integer $len     需要转换成*的字符个数，当$type=4时，表示右侧保留长度
     * @param  integer $type    类型：0从左向右；1从右向左；2指定字符位置分割前由右向左；3指定字符位置分割后由左向右；4保留首末指定字符串
     * @param  string  $glue    分割符
     * @return string           处理后的字符串
     */
    public function hideStr($string, $bengin = 0, $len = 4, $type = 0, $glue = "*")
    {
        if (empty($string))
            return false;
        $array = array();
        if ($type == 0 || $type == 1 || $type == 4) {
            $strlen = $length = mb_strlen($string);
            while ($strlen) {
                $array[] = mb_substr($string, 0, 1, "utf8");
                $string = mb_substr($string, 1, $strlen, "utf8");
                $strlen = mb_strlen($string);
            }
        }
        switch ($type) {
            case 1:
                $array = array_reverse($array);
                for ($i = $bengin; $i < ($bengin + $len); $i++) {
                    if (isset($array[$i]))
                        $array[$i] = "*";
                }
                $string = implode("", array_reverse($array));
                break;
            case 2:
                $array = explode($glue, $string);
                $array[0] = self::hideStr($array[0], $bengin, $len, 1);
                $string = implode($glue, $array);
                break;
            case 3:
                $array = explode($glue, $string);
                $array[1] = self::hideStr($array[1], $bengin, $len, 0);
                $string = implode($glue, $array);
                break;
            case 4:
                $left = $bengin;
                $right = $len;
                $tem = array();
                for ($i = 0; $i < ($length - $right); $i++) {
                    if (isset($array[$i]))
                        $tem[] = $i >= $left ? "*" : $array[$i];
                }
                $array = array_chunk(array_reverse($array), $right);
                $array = array_reverse($array[0]);
                for ($i = 0; $i < $right; $i++) {
                    $tem[] = $array[$i];
                }
                $string = implode("", $tem);
                break;
            default:
                for ($i = $bengin; $i < ($bengin + $len); $i++) {
                    if (isset($array[$i]))
                        $array[$i] = "*";
                }
                $string = implode("", $array);
                break;
        }
        return $string;
    }
}