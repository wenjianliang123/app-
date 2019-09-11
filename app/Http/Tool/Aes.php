<?php

namespace App\Http\Tool;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Aes extends Controller
{
    //AES加密解密
    private $hex_iv = ''; # converted JAVA byte code in to HEX and placed it here

    private $key; #Same as in JAVA

    public function __construct($key) {
        $this->key = $key;
        //$this->key = hash('sha256', $this->key, true);
    }

    //老版本的 mcrypt拓展
    /*
    function encrypt($str) {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->hexToStr($this->hex_iv));
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $pad = $block - (strlen($str) % $block);
        $str .= str_repeat(chr($pad), $pad);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encrypted);
    }
    function decrypt($code) {
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $this->hexToStr($this->hex_iv));
        $str = mdecrypt_generic($td, base64_decode($code));
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $this->strippadding($str);
    }*/

    public function encrypt($input)
    {
        $data = openssl_encrypt($input, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
//        $data = base64_encode($data);  //base64编码
        //自己加的urlencode
//        $data=urlencode($data);//自己写的 防止参数携带特殊字符 用于base64
        $data = bin2hex($data);  //普通编码转成16进制
        return $data;
    }

    public function decrypt($input)
    {
        //自己加的urldecode() 用来解密 urlencode() 用于base64
//        $input = urldecode($input);//自己写的
//        $input = base64_decode($input);

        $input = hex2bin($input);  //16进制转为普通编码
        $decrypted = openssl_decrypt($input, 'AES-128-ECB', $this->key, OPENSSL_RAW_DATA, $this->hexToStr($this->hex_iv));
        return $decrypted;
    }

    /*
      For PKCS7 padding
     */
    private function addpadding($string, $blocksize = 16) {

        $len = strlen($string);

        $pad = $blocksize - ($len % $blocksize);

        $string .= str_repeat(chr($pad), $pad);

        return $string;

    }

    private function strippadding($string) {

        $slast = ord(substr($string, -1));

        $slastc = chr($slast);

        $pcheck = substr($string, -$slast);

        if (preg_match("/$slastc{" . $slast . "}/", $string)) {

            $string = substr($string, 0, strlen($string) - $slast);

            return $string;

        } else {

            return false;

        }

    }

    function hexToStr($hex)
    {
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2)
        {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }
}


