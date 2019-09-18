<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods_attribute_model;
use App\Model\Goods_type_model;

class AttributeController extends Controller
{
    //添加页面
    public function add()
    {
        $type_info=Goods_type_model::get();
//        dd($type_info);
        return view("admin.new_goods.attribute.add",['type_info'=>$type_info]);
    }
    //执行添加
    public function do_add(Request $request)
    {
        $data=$request->all();
        $attribute_name=$request->all()['attribute_name'];
        $type_id=$request->all()['type_id'];
        $attribute_is=$request->all()['attribute_is'];

//        dd($attribute_is);
//        goods_category
        $result=Goods_attribute_model::insert([
            'attribute_name'=>$attribute_name,
            'type_id'=>$type_id,
            'attribute_is'=>$attribute_is,
        ]);
        if($result){
            echo json_encode(['code'=>200,'msg'=>'添加成功'],JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode(['code'=>500,'msg'=>'添加失败'],JSON_UNESCAPED_UNICODE);
        }

    }
    //接口数据
    public function index(Request $request)
    {
        //查询属性列表
        //拿到 类型页面传回来的类型id
        $type_id=$request->input('type_id');
//        dd($type_id);//null
        $where=[];
        if($type_id!=='null'){
            $where[]=['type_id','=',"$type_id"];
        }
//        $search_info!=='NULL'
        $data=Goods_attribute_model::where($where)->get()->toarray();
//        dd($where);
        foreach ($data as $key=> $v)
        {
            //思路
//            $a=1;//1查出来的数量
//            $data[0]['hh']=$aa;
//            $v['type_id'];
            $aa=Goods_type_model::where('type_id',$v['type_id'])->value('type_name');
//            dump($aa);
            $data[$key]['type_name']=$aa;
        }
        echo json_encode(['code'=>200,'msg'=>'成功','data'=>$data],JSON_UNESCAPED_UNICODE);
    }
    //属性展示
    public function attr_list(Request $request)
    {
        //用于查询该类型下的属性
//        dd();
        $type_info=Goods_type_model::get()->toarray();
//
       $type_id=$request->type_id;
//       dd(1);
//        dd($type_id);
        if($type_id!=null){
//            dd(11);
            return view('admin.new_goods.attribute.attr_list',['type_id'=>$type_id,'type_info'=>$type_info]);
        }else{
//            dd(112);
            return view('admin.new_goods.attribute.attr_list',['type_info'=>$type_info]);
        }

//        dd($type_id);

    }
    //批量删除
    public function pishan(Request $request)
    {
        $attribute_id_info=ltrim($request->all()['attr_id'],',');
//        dd($attribute_id_info);
        $result=Goods_attribute_model::destroy($attribute_id_info);
//        dd($result);
        if($result){
            return json_encode(['code'=>200,'msg'=>'批删成功']);
        }else{
            return json_encode(['code'=>500,'msg'=>'批删失败']);
        }
    }
}
