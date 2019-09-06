<?php

namespace App\Http\Controllers\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload_view()
    {
        //form-data POST //表单对象上传 异步文件上传和同步（普通表单）差不多
        return view("upload.upload");
    }
    //form-data POST //表单对象上传 异步文件上传和同步（普通表单）差不多
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
    /*//执行二进制文件上传 老师带的写的
    public function upload_binary()
    {
        //报413是你的图片太大了
        //接收原始数据流数据 （二进制流 xml、json）
        $data=file_get_contents("php://input");
//        dd($data);
//        dd($data);
        //保存图片
        //拿到后缀名
        $extension_name=$this->check_image_type($data);
        //判断种类 先拿到后缀名转小写
        $data_type="image/".strtolower($extension_name);
        $allowType=array("image/jpeg","image/jpg","image/png","imgae/gif");
        //判断种类
        if(!in_array($data_type,$allowType)){
            echo "文件类型不是 image/jpeg,image/jpg,image/png,imgae/gif";
        }

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
    }*/
    
    
    //优化检测类型 优化 生成文件夹 完成今日作业 询问搜索高亮
    //upload_binary  执行二进制文件上传 老师带的写的
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
