<?php

namespace App\Http\Controllers\Api;

use App\Http\Tool\common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SignController extends Controller
{
    public function index(){
        $name=$_GET['name'];
        $sex=$_GET['sex'];
        $age=$_GET['age'];
        $timestamp=$_GET['timestamp'];
        $sign_get=$_GET['sign'];
        $new_arr=array('name'=>$name,'sex'=>$sex,'age'=>$age);
        /*//字典排序
        sort($trr_arr,SORT_STRING);
        $trr_arr=implode($trr_arr);
        $trr_arr=md5(base64_encode(strtoupper(sha1($trr_arr))));
        dd($trr_arr);
        if ($sign==$trr_arr){
            echo "ok";
        }else{
            echo "no";
        }*/

        $string = $this->ToUrlParams($new_arr);
//        dd($string);
        //签名步骤二：在string后加入access_token
        $string = $string . "&key=".common::get_access_token();

        //签名步骤三：将str进行base64加密
        $string  = base64_encode($string);
//        dd($string);
        //将时间变为时间戳
//        dd(strtotime('2019-09-06 09:58:00'));//1567763880
        //将时间戳变为时间
//        dd(date('Y-m-d H:i:s', 1567763880));

        //签名步骤四：将base64加密的字符串拼接上时间戳
        $string   .=$timestamp;
//        dd($string);
        //签名步骤五：MD5加密
        $string = md5($string);
//        dd($string);
        //签名步骤六：进行时间截取
        $start = (int) substr($timestamp,-1);
//        dd($start);
        //签名步骤七：进行签名截取 从0开始截取22位
        $sign = substr($string, $start, 22 - $start);
//        dd($sign);
        ////签名步骤八：所有字符转为大写
        $result = strtoupper($sign);
//        dd($result);//ABE2185224F613BE9D8D5D

//        解密成功的： http://www.dijiuyue.com/sign?name=111&sex=222&age=333&sign=ABE2185224F613BE9D8D5D&timestamp=1567763880
        if($sign_get == $result){
//            return true;
            echo "解密成功!";
        }else{
//            return false;
            echo "解密失败~~~！";
        }


    }

    /**
     * 将参数拼接为url: key=value&key=value
     * @param   $params
     * @return  string
     */
    private function ToUrlParams( $params ){
        $string = '';
        if( !empty($params) ){
            $array = array();
            foreach( $params as $key => $value ){
                if(!empty($value)){
                    $array[] = $key.'='.$value;
                }

            }
            $string = implode("&",$array);
        }
        return $string;
    }

}
