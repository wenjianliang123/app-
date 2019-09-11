<?php

namespace App\Http\Controllers\Encrypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EncryptController extends Controller
{

    //凯撒加密
    function jiami($str){
//        $arr=range('a','z');
            $arr="abcdefghijklmnopqrstuvwxyz";
        for ($i=0;$i<strlen($str);$i++){
            $key=strpos($arr,$str[$i])+3;
            if($key>25){
                $key=$key-26;
            }
            echo substr($arr,$key,1);
        }
    }
    //凯撒解密
    function jiemi($encrypt){
//        $arr=range('a','z');
        $arr="abcdefghijklmnopqrstuvwxyz";
        for ($i=0;$i<strlen($encrypt);$i++){
            $key=strpos($arr,$encrypt[$i])-3;
            if($key>25){
                $key=$key-26;
            }
            echo substr($arr,$key,1);
        }
    }
    //凯撒运用
    public function index()
    {
        //凯撒加密
        $str_1='abcdefghijklmnopqrstuvwxyz';
//        $this->jiami($str_1);die();
        //凯撒解密
        $jiami_1='defghijklmnopqrstuvwxyzabc';
//        $this->jiemi($jiami_1);die();


    }





}
