<?php

namespace App\Http\Controllers\EveryDay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * 0916
     * a 自己封装自定义函数 实现反转字符串 strrev函数的功能
     */
    public function test_1_0916()
    {
        $str='ab1';
        echo $this->str_rev($str);

    }
    //比较好的方法
    function str_rev_1($string)
    {
        $length = strlen($string);
        for ($i = 0, $j = $length - 1; $i < ($length / 2); $i++, $j--) {
            $t = $string[$i];
            $string[$i] = $string[$j];
            $string[$j] = $t;
        }
        return $string;
    }
    //遍历次数比上面多一次
    function str_rev($string)
    {
        $i = strlen($string) - 1;
        $str = '';
        while (isset($string[$i])) {
            $str .= $string[$i];
            $i--;
        }
        $str_length=strlen($str);
        $str_length_2=$str_length/2;
        $str_1=substr($str,$str_length_2);
        return $str_1;
    }

    /**
     * 0916
     * b 封装自定义函数，实现反转中文字符串的功能
     */

    public function Chinese_fanzhuan()
    {
        $str="问建梁1";
//        echo $this->str_rev_gb($str);
        echo $this->strReverse($str);
    }
    //mb_strlen方法实现中文反转 较差 步骤较多
    function str_rev_gb($str){
             //判断输入的是不是utf8类型的字符，否则退出
     if(!is_string($str)||!mb_check_encoding($str,'UTF-8')){
                     exit("输入类型不是UTF8类型的字符串");
     }
     $array=array();
     //将字符串存入数组
     $l=mb_strlen($str,'UTF-8');
     for($i=0;$i<$l;$i++){
         $array[]=mb_substr($str,$i,1,'UTF-8');
     }
     //反转字符串
     krsort($array);
     //拼接字符串
     $string=implode($array);
     return $string;
 }
    //iconv_strlen()方法实现中文反转 较好
    function strReverse($str1)
    {
        $str2 = '';
        $len = iconv_strlen($str1);
        for ($i = $len - 1; $i > -1; $i--) {
            $str2 .= iconv_substr($str1, $i, 1);
        }
        return $str2;
    }


}
