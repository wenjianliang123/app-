<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin_login;

class LoginController extends Controller
{
    public function login(){

        return view("admin.login");
    }

    public function do_login(Request $request)
    {
//        dd(session('admin_user_id'));
        $user_info=$request->all();
//        dd($user_info);
        $info=Admin_login::where('admin_user_name',$user_info['admin_user_name'])->first();
        if($info){
            //有这个用户验证密码
            //传回来的密码
            $admin_user_pwd_info=$user_info['admin_user_pwd'];
//            dd($admin_user_pwd_info);
            //数据库中的密码和传回来的密码进行对比
            if($info['admin_user_pwd']==$admin_user_pwd_info){
                //密码相符
//                dd($request->session()->put('admin_user_id', $info['user_id']));
                session(['admin_user_id' => $info['user_id']]);

                return json_encode(['code'=>200,'msg'=>'登陆成功']);
            }else{
                return json_encode(['code'=>500,'msg'=>'用户号码或密码不对']);
            }
        }
    }

    public function register()
    {
        return view("admin.register");
    }

    public function do_register(Request $request)
    {
        $data=$request->except(['_token','admin_user_repwd']);
//        dd($data);
        //唯一性验证
        $db_user_info=Admin_login::where('admin_user_name',$data['admin_user_name'])->first();
        if($db_user_info){
            //已存在
            echo "<script>alert('用户名已存在!');history.back();</script>";
        }
        $result=Admin_login::insert([
            'admin_user_name'=>$data['admin_user_name'],
            'admin_user_pwd'=>$data['admin_user_pwd'],
        ]);

        if($result)
        {
//            echo '<script>alert("注册成功");window.location.href="admin/student/index";</script>';

//            return redirect("admin/student/index");
            return view('admin/success')->with([
                //跳转信息
                'message'=>'注册成功！',
                //自己的跳转路径
                'url' =>asset('admin/login'),
                //跳转路径名称
                'urlname' =>'登陆页面',
                //跳转等待时间（s）
                'jumpTime'=>0,
            ]);

        }else{
            echo "<script>alert('注册失败!');history.back();</script>";
//            return redirect("admin/login/register");
        }


    }
}
