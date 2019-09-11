<?php

namespace App\Http\Controllers\Encrypt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Tool\Aes;
use App\Model\Aes_self_encrypt_user_model;

class AesController extends Controller
{
    public function aes_running()
    {
        echo phpinfo();die();

//        $obj = new Aes('fdjfdsfjakfjadii');
        $obj = new Aes('wenjianliang');
        $url = "name=杨瑞娴&age=31&mobile=15388551679";
//        echo $eStr = $obj->encrypt($url);
//        echo "<hr>";
//        echo $newStr = $obj->decrypt($eStr);die;
//        echo "<hr>";
        $authstr=$obj->encrypt($url);

        $url=file_get_contents("http://www.dijiuyue.com/api/encrypt/Aes_self_encrypt?authstr=".$authstr);
        dd($url);

    }

    public function Aes_self_encrypt(Request $request)
    {
        //自己的测试数据
        //name=问建梁&age=22&mobile=13613445132//f6f254737778fb8a6813130e9671ec1f2a2ca63ac200b8aab72c9cbd952ec7c2b8f2ddb5dfbb11cdd76da69f652c31d8

//        $url = "name=杨瑞娴&age=31&mobile=15388551679";
//        69dfa0f8a0f257c6bfe8bc9c2761586d82d999f5cbfe31dd8263b8b897b29fdd96e42d177b62e5f8e1473cb24c366147

        $data=implode($request->all());
//        dd($data);
        $obj = new Aes('wenjianliang');
        $new_str=[];
        $new_str = $obj->decrypt($data);
        /**
         * php获取url参数 给他一个name=111&age=222&mobile=2333 返回的是 array([
         *      'name'=>'',
         *      'age'=>'',
         *      'mobile'=>''
         * ])
         */
        $url = $new_str;
//        dd($url);
        $arr = parse_url($url);
//        var_dump($arr);
        $arr_query = $this->convertUrlQuery($arr['path']);
//        var_dump($arr_query);//能够直接获取的结果
//        var_dump($this->getUrlQuery($arr_query));//将数组变为url参数
//        die();
//        dump($data);
//        dump($new_str);die();
//
        if(strlen($data)==96){
            //数据正常
                $user_info=Aes_self_encrypt_user_model::where([
                    'user_name'=>$arr_query['name'],
                    'user_age'=>$arr_query['age'],
                    'user_mobile'=>$arr_query['mobile'],
                ])->first();
//                dd($user_info);
                //判断是否有该用户
                if($user_info){
                    //有该用户
                    echo "您已经注册!";die();
                }else{
                    $result=Aes_self_encrypt_user_model::insert([
                        'user_name'=>$arr_query['name'],
                        'user_age'=>$arr_query['age'],
                        'user_mobile'=>$arr_query['mobile'],
                    ]);
//            dd($result);
                    if($result){
                        echo "添加成功";
                    }else {
                        echo "添加失败";die();
                    }
                }
        }else{
            echo "数据不正确";die();
        }
//        李子恒版 可用
        /*$req=$request->all();
//         dd($req);
        $obj = new Aes('wenjianliang');
        $url=$req["authstr"];
        $len=strlen($url);
//         dd($len);
        if ($len == 96) {
            $eStr = $obj->decrypt($url);
            // $array=explode("&",$eStr);
            $queryParts = explode('&', $eStr);
//            dd($queryParts);
//            $params = array();
            foreach ($queryParts as $param) {
                $item = explode('=', $param);
                $params[$item[0]] = $item[1];
            }
//             dd($params);

            $user_info=Aes_self_encrypt_user_model::where([
                    'user_name'=>$params['name'],
                    'user_age'=>$params['age'],
                    'user_mobile'=>$params['mobile'],
                ])->first();
//                dd($user_info);
//                //判断是否有该用户

            if($user_info !=''){
                echo "您已注册";
            }else{
                $data =Aes_self_encrypt_user_model::insert([
                    'user_name'=>$params['name'],
                    'user_age'=>$params['age'],
                    'user_mobile'=>$params['mobile'],
                ]);
                if ($data) {
                    return json_encode(['code'=>'200','msg'=>"添加成功"],JSON_UNESCAPED_UNICODE);
                }else{
                    return json_encode(['code'=>'201','msg'=>"添加失败，数据格式错误"],JSON_UNESCAPED_UNICODE);

                }
            }

        }else{
            return json_encode(['code'=>'201','msg'=>"接收失败，数据格式错误"],JSON_UNESCAPED_UNICODE);*/



        /*$name=$data['name'];
        $age=$data['age'];
        $mobile=$data['mobile'];
//        dd($data);
        $new_str='';
        $obj = new Aes('wenjianliang');
        $url = "name=问建梁&age=22&mobile=13613445132";
        $new_str=$obj->encrypt($url);
        echo "<hr>";
        $new_str_1=$obj->decrypt($new_str);
//        dump($new_str);/
        dump($new_str_1);//f6f254737778fb8a6813130e9671ec1f2a2ca63ac200b8aab72c9cbd952ec7c2b8f2ddb5dfbb11cdd76da69f652c31d8*/

    }

    /**
     * 将字符串参数变为数组
     * @param $query
     * @return array array (size=10)
    'm' => string 'content' (length=7)
    'c' => string 'index' (length=5)
    'a' => string 'lists' (length=5)
    'catid' => string '6' (length=1)
    'area' => string '0' (length=1)
    'author' => string '0' (length=1)
    'h' => string '0' (length=1)
    'region' => string '0' (length=1)
    's' => string '1' (length=1)
    'page' => string '1' (length=1)
     */
    //将name=问建梁&age=22&mobile=13613445132
    //变为$arr=[
    //'name'=>问建梁,
//    'age'=>22,
//    'mobile'=>13613445132
    //    ]
    function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
//            dump($item);
            /*array:2 [
                0 => "name"
                1 => "问建梁"
                ]
              array:2 [
                0 => "age"
                1 => "22"
               ]
              array:2 [
                0 => "mobile"
                1 => "13613445132"
            ]*/
            $params[$item[0]] = $item[1];//循环让$item[0]也就是name =$item[1]也就是问建梁 放进一个数组中
        }
        return $params;
    }

    /**
     * 将参数变为字符串
     * @param $array_query
     * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0&region=0&s=1&page=1' (length=73)
     */
    function getUrlQuery($array_query)
    {
        $tmp = array();
        foreach ($array_query as $k => $param) {
            $tmp[] = $k . '=' . $param;
        }
        $params = implode('&', $tmp);
        return $params;
    }




}
