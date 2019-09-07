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
    public function upload()
    {
//        dd($_POST);
//        var_dump($_FILES);
    $file=$_FILES['file'];
//    dd($file);
        $allowType=array("image/jpeg","image/jpg","image/png","imgae/gif");
        //判断大小是否超过2MB
        if($file['size']>1024*1024*2){
            echo "文件大小超过2MB";
            //判断类型
        }elseif(!in_array($file['type'],$allowType)){
            echo "文件类型不是 image/jpeg,image/jpg,image/png,imgae/gif";
            //判断错误号
        }elseif($file['error']!=0){
            echo "这是错误号不为零的错误";
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
        if($file_is){
            echo "上传成功,上传的文件在当前项目中的public目录下,但是不建议在项目中做，最好在localhost中做";//
        }
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
    /*public function upload_binary()
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

    }*/

    /**
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

   /**
    * 执行二进制文件上传
    * 方法二 老师的思路(从前台直接传数据回来file.name file.size file.type)
    * 自己执行了一遍
    */
    public function upload_binary()
    {
        //从前台url地址传过来的文件信息
        $file_info=$_GET;
        $file_name=$file_info['file_name'];
        $file_size=$file_info['file_size'];
        $file_type=$file_info['file_type'];

        //报413是你的图片太大了
        //接收原始数据流数据 （二进制流 xml、json）
        $data=file_get_contents("php://input");
//        dd($data);
//        dd($data);
        //保存图片
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

        $this->create_file_info($extension_name,$data);
    }

    /**
     * base64文件上传 就是 data:banse64;image/jpeg,btmunbvdcs...的格式
     * 传回来的字符串就是一个可直接打开的图片url 图片预览的大多数插件就是用这个url做的
     * 原理还是二进制流 但是经过base64加密后可以用jqueryAJAX传输
     * 传输的数据就是一些普通的字符串
     * 用$_POST接收 用file_put_contents存储
     */


}
