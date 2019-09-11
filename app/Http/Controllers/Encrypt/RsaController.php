<?php

namespace App\Http\Controllers\Encrypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Tool\Rsa;

class RsaController extends Controller
{
    public function Rsa_running()
    {
//        echo phpinfo();die();

        //举个粒子
        $Rsa = new Rsa();
// $keys = $Rsa->new_rsa_key(); //生成完key之后应该记录下key值，这里省略
// p($keys);die();
        $privkey =file_get_contents("./Public_and_Private_Key/private_key.pem");//$keys['privkey'];
        $pubkey  =file_get_contents("./Public_and_Private_Key/public_key.pem");//$keys['pubkey'];
//echo $privkey;die;
//初始化rsaobject
        $Rsa->init($privkey, $pubkey,TRUE);

//原文
        $data = '问建梁真好看';

//私钥加密示例
        $encode = $Rsa->priv_encode($data);
        p($encode);
        $ret = $Rsa->pub_decode($encode);
        p($ret);

//公钥加密示例
        $encode = $Rsa->pub_encode($data);

        p($encode);
        $ret = $Rsa->priv_decode($encode);
        p($ret);



    }

}


//在类外封装的方法
function p($str){
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}
