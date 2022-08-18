<?php
namespace src;

class Common
{
    /**
     * @desc 通过一个总金额和总个数，生成不同的红包金额，可用于微信发放红包
     * @param $total [你要发的红包总额]
     * @param int $num [发几个]，默认为10个
     * @return array [生成红包金额数组]
     */
    public function getRedGift($total, $num = 10)
    {
        $min = 0.01;
        $temp = array();
        $return = array();
        for ($i = 1; $i < $num; ++$i) {
            $safe_total = ($total - ($num - $i) * $min) / ($num - $i); //红包金额的最大值
            if ($safe_total < 0) break;
            $money = @mt_rand($min * 100, $safe_total * 100) / 100;//随机产生一个红包金额
            $total = $total - $money;// 剩余红包总额
            $temp[$i] = round($money, 2);//保留两位有效数字
        }
        $temp[$i] = round($total, 2);
        $return['money_sum'] = $temp;
        $return['new_total'] = array_sum($temp);
        return $return;
    }

    /**
     * 身份证号验证
     * @param $id string 身份证号码
     * @return bool
     */
    public function isIdCard($id)
    {
        $id = strtoupper($id);
        $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
        $arr_split = array();
        if(!preg_match($regx, $id))
        {
            return false;
        }
        if(15==strlen($id)) //检查15位
        {
            $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

            @preg_match($regx, $id, $arr_split);
            //检查生日日期是否正确
            $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
            if(!strtotime($dtm_birth))
            {
                return false;
            } else {
                return true;
            }
        }
        else      //检查18位
        {
            $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
            @preg_match($regx, $id, $arr_split);
            $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
            if(!strtotime($dtm_birth)) //检查生日日期是否正确
            {
                return false;
            }
            else
            {
                //检验18位身份证的校验码是否正确
                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                $sign = 0;
                for ( $i = 0; $i < 17; $i++ )
                {
                    $b = (int) $id{$i};
                    $w = $arr_int[$i];
                    $sign += $b * $w;
                }
                $n = $sign % 11;
                $val_num = $arr_ch[$n];
                if ($val_num != substr($id,17, 1))
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    }

    /**
     * 富文本数据进行转换成文本
     * @access  public
     * @param   $content  string  富文本数据
     * @return  string    不包含标签的文本
     */
    public function contentFormat($content = '')
    {
        if (empty($content))
            return false;
        $formatData = htmlspecialchars_decode($content);//把一些预定义的 HTML 实体转换为字符
        return strip_tags($formatData);//函数剥去字符串中的 HTML、XML 以及 PHP 的标签,获取纯文本内容
    }
}