<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\wechat_openid;

class UserRestfulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //列表展示
    public function index()
    {
        $data =wechat_openid::get()->toArray();
        return json_encode(['code'=>'200','data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //做后端时写return view()添加页面的
    public function create()
    {
        echo "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //执行添加
    public function store(Request $request)
    {
        $user_name= $request->input('user_name');
        $user_tel=$request->input('user_tel');
        if (empty($user_name)||empty($user_tel)){
            return json_encode(['code'=>400,'msg'=>'用户名和电话参数不能为空']);
        }
        $res=wechat_openid::insert([
            'user_name'=>$user_name,
            'user_tel'=>$user_tel
        ]);
        if($res){
            return json_encode(['code'=>200,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'添加失败,程序异常,请联系管理员']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //修改查询用户信息
    public function show($user_id)
    {
        if (empty($user_id)){
            return json_encode(['code'=>400,'msg'=>'用户ID参数不能为空']);
        }
        $data=wechat_openid::where('user_id',$user_id)->first();
        return json_encode(['code'=>'200','data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //做后端时写return view()修改页面的
    public function edit($id)
    {
        echo "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //执行修改
    public function update(Request $request, $user_id)
    {
//        $user_id=$request->input('user_id');
        $user_name=$request->input('user_name');
        $user_tel=$request->input('user_tel');
        $wechat_openid_model = wechat_openid::find($user_id);
        $wechat_openid_model->user_name = $user_name;
        $wechat_openid_model->user_tel = $user_tel;
        $result=$wechat_openid_model->save();
        if($result){
            return json_encode(['code'=>200,'msg'=>'修改成功']);
        }else{
            return json_encode(['code'=>500,'msg'=>'修改失败']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //执行删除
    public function destroy($user_id)
    {
        $res= wechat_openid::where(['user_id'=>$user_id])->delete();
        if($res){
            return json_encode(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'删除失败,程序异常,请联系管理员']);
        }
    }
}
