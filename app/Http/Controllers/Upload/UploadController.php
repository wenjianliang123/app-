<?php

namespace App\Http\Controllers\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    //表单form-data 视图
    public function upload_view()
    {
        //form-data POST //表单对象上传 异步文件上传和同步（普通表单）差不多
        return view("upload.upload");
    }
    /**
     * form-data POST //表单对象上传 异步文件上传和同步（普通表单）差不多
     * 用$_FILES接收 本质和表单一样 从前台传过来一个对象进行处理
     * 用move_uploaded_file移动文件 php已经自动完成了文件上传 所需做的就是移动位置
     */
    public function upload($file)
    {
//        dd($_POST);
//        var_dump($_FILES);
//    $file=$_FILES['file'];
//    dd($file);
        $allowType=array("image/jpeg","image/jpg","image/png","imgae/gif");
        //判断大小是否超过2MB
        if($file['size']>1024*1024*2){
            echo "文件大小超过2MB";die();
            //判断类型
        }elseif(!in_array($file['type'],$allowType)){
            echo "文件类型不是 image/jpeg,image/jpg,image/png,imgae/gif";die();
            //判断错误号
        }elseif($file['error']!=0){
            echo "这是错误号不为零的错误";die();
        }
        //后缀名
        $extension_name=pathinfo($file['name'],PATHINFO_EXTENSION);
//        dd($extension_name);
        //新的不重复的名字 --理论上
        $new_name=md5(time().rand(1000,9999).$file['name']).'.'.$extension_name;
        //建一个 2019-9-6格式的日期文件夹
        $date=date("Y-n-j");
//        dd($date);
        $file_dir="./image/".$date;
        //如果不存在创建
        if(!file_exists($file_dir)){
            mkdir($file_dir);
        }
        $move=$file_dir.'/'.$new_name;
        $file_is=move_uploaded_file($file['tmp_name'],$move);
        return $move;
//        if($file_is){
//            echo "上传成功,上传的文件在当前项目中的public目录下,但是不建议在项目中做，最好在localhost中做";//
//        }
    }

    //二进制流视图
    public function upload_binary_view()
    {
        return view("upload.upload_binary_view");
    }
    /**
     * 执行二进制文件上传 传过来的是一个乱码的二进制流文件 多用于移动端
     * 方法一 老师带的写的
     * 不可以用jqueryAJAX传输 只能用原生的AJAX
     * 用file_get_contents("php://input")接收原始数据
     * 用file_put_contents存储
     */
    public function upload_binary()
    {
        //检查二进制流图片类型 --老师带的写的
        function check_image_type($data)
        {
            $bits = array(
                'JPEG' => "\xFF\xD8\xFF",
                'GIF' => "GIF",
                'PNG' => "\x89\x50\x4e\x47\x0d\x0a\x1a\x0a",
                'BMP' => 'BM',
            );
            foreach ($bits as $type => $bit) {
                if (substr($data, 0, strlen($bit)) === $bit) {
                    return $type;
                }
            }
            return 'UNKNOWN IMAGE TYPE';
        }
        //报413是你的图片太大了
        //接收原始数据流数据 （二进制流 xml、json）
        $data=file_get_contents("php://input");
//        dd($data);
//        dd($data);
        //保存图片
        //拿到后缀名
        $extension_name=check_image_type($data);
        //判断种类 先拿到后缀名转小写
        $data_type="image/".strtolower($extension_name);
        $allowType=array("image/jpeg","image/jpg","image/png","imgae/gif");
        //判断种类
        if(!in_array($data_type,$allowType)){
            echo "文件类型不是 image/jpeg,image/jpg,image/png,imgae/gif";
        }
        //创建文件夹和新的不重复文件名 传过去一个后缀名 和 资源数据
        $this->create_file_info($extension_name,$data);

    }


   /**
    * 执行二进制文件上传  超简单自己写的😄😄😄😄
    * 方法二 老师的思路(从前台直接传数据回来file.name file.size file.type)
    * 自己执行了一遍
    */
    /*public function upload_binary()
    {
        //从前台url地址传过来的文件信息
        $file_info=$_GET;
        //报413是你的图片太大了
        //接收原始数据流数据 （二进制流 xml、json）
        $data=file_get_contents("php://input");
//        dd($data);
//        dd($data);
        //保存图片
//        封装的生成后缀名、判断文件大小、类型的方法、以及生成文件夹
        $this->create_extension_name_and_file_name_and_file_dir($file_info,$data);
    }*/

    /**
     * base64文件上传 就是 data:banse64;image/jpeg,btmunbvdcs...的格式
     * 传回来的字符串就是一个可直接打开的图片url 图片预览的大多数插件就是用这个url做的
     * 原理还是二进制流 但是经过base64加密后可以用jqueryAJAX传输
     * 传输的数据就是一些普通的字符串
     * 用$_POST接收 用file_put_contents存储
     */
    //base64文件上传视图
    public function upload_Base64_view()
    {
        return view("upload.uploadBase64");
    }
    //执行Base64文件上传 方法一 老师自己写的 自己又做了优化
    public function upload_Base64()
    {
        //从前台url地址传过来的文件信息
        $file_info=$_GET;
    //
//        echo 1;
        $data=$_POST['img'];//ajax传值 $_POST接值
//        dd($data);
        $n=strpos($data,",");//计算逗号在这些字符串中首次初次的位置//22
//        dd($n);
        $sub_str=substr($data,$n+1);//抛去data:image/jpeg;banse64,剩下的字符串
//        dd($sub_str);
        $sub_str=base64_decode($sub_str);
//        dd($sub_str);
        //保存图片
        //封装的生成后缀名、判断文件大小、类型的方法、以及生成文件夹
        $this->create_extension_name_and_file_name_and_file_dir($file_info,$sub_str);
    }
    
    //执行Base64文件上传 方法二 老师复制到网上的 看不太懂 正则表达式
    /*public function upload_Base64()
    {
        $base64_image_content = $_POST['img'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/',$base64_image_content,$result)){
            $type = $result[2];//图片后缀
            //$_SERVER['DOCUMENT_ROOT'] 当前运行脚本所在的根目录。
            $new_file = $_SERVER['DOCUMENT_ROOT'].'/upload/';//"D:\wnmp\www\dijiuyue\public/upload/"
//            dd($new_file);
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }

            $filename = time() . '_' . uniqid() . ".{$type}"; //文件名 //uniqid生成唯一的id 但不绝对 绝对唯一是md5()
            $new_file = $new_file . $filename;
            //写入操作
            if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                echo "上传成功";
            }
        }


    }*/


    /**
     * @param $file_info 前台接收回来的数据
     * @param $data 处理好的可以直接写入文件的数据
     * 封装的生成后缀名、判断文件大小、类型的方法、以及生成文件夹 (***自己写的***)
     * ***************************新的优化思路 *****************************
     * 在下面的判断大小和类型以及错误号 用||或者 以及 if$error 存在 判断错误号
     */
    public function create_extension_name_and_file_name_and_file_dir($file_info, $data)
    {
        //拿到后缀名
        $extension_name=pathinfo($file_info['file_name'],PATHINFO_EXTENSION);
        //判断种类 先拿到后缀名转小写
        $allowType=array("image/jpeg","image/jpg","image/png","imgae/gif");
        //判断大小是否超过2MB
        if($file_info['file_size']>1024*1024*2){
            echo "文件大小超过2MB";
            //判断类型
        }elseif(!in_array($file_info['file_type'],$allowType)){
            echo "文件类型不是 image/jpeg,image/jpg,image/png,imgae/gif";
        }
//        return $extension_name;
        //新的不重复的名字 --理论上
        $new_name=md5(time().rand(1000,9999)).'.'.$extension_name;
        //建一个 2019-9-6格式的日期文件夹
        $date=date("Y-n-j");
//        dd($date);
        $file_dir="./image/".$date;
        //如果不存在创建
        if(!file_exists($file_dir)){
            mkdir($file_dir);
        }
        $move=$file_dir.'/'.$new_name;
//        dd($move);
        //二进制没存到服务器 只是接了一个字符串 所以不能move_uploaded_file
        // 可以在前台的url里面拼接
        $file_is=file_put_contents($move,$data);
        if($file_is){
            echo "上传成功,上传的文件在当前项目中的public目录下,但是不建议在项目中做，最好在localhost中做";//
        }
    }


    /**
     * 不成熟的但能用
     * 封装的生成后缀名、判断文件大小、类型的方法
     * 最后返回后缀名 以供之后代码运行
     */
    public function add_extension_name_and_judge_file_size_type($file_name,$file_size,$file_type){
        //拿到后缀名
        $extension_name=pathinfo($file_name,PATHINFO_EXTENSION);
        //判断种类 先拿到后缀名转小写
        $allowType=array("image/jpeg","image/jpg","image/png","imgae/gif");
        //判断大小是否超过2MB
        if($file_size>1024*1024*2){
            echo "文件大小超过2MB";
            //判断类型
        }elseif(!in_array($file_type,$allowType)){
            echo "文件类型不是 image/jpeg,image/jpg,image/png,imgae/gif";
        }
        return $extension_name;
    }


    /**
     * 不成熟的但能用
     * 封装的二进制创建文件夹和文件名的方法
     */
    function create_file_info($extension_name,$data)
    {
        //新的不重复的名字 --理论上
        $new_name=md5(time().rand(1000,9999)).'.'.$extension_name;
        //建一个 2019-9-6格式的日期文件夹
        $date=date("Y-n-j");
//        dd($date);
        $file_dir="./image/".$date;
        //如果不存在创建
        if(!file_exists($file_dir)){
            mkdir($file_dir);
        }
        $move=$file_dir.'/'.$new_name;
//        dd($move);
        //二进制没存到服务器 只是接了一个字符串 所以不能move_uploaded_file
        // 可以在前台的url里面拼接
        $file_is=file_put_contents($move,$data);
        if($file_is){
            echo "上传成功,上传的文件在当前项目中的public目录下,但是不建议在项目中做，最好在localhost中做";//
        }
    }
}
