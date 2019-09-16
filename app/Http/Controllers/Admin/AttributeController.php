<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods_attribute_model;
use App\Model\Goods_type_model;

class AttributeController extends Controller
{
    public function add()
    {
        $type_info=Goods_type_model::get();
//        dd($type_info);
        return view("admin.new_goods.attribute.add",['type_info'=>$type_info]);
    }

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

    public function index()
    {
        $data=Goods_attribute_model::get()->toarray();
//        dd($data);
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
//        return view("admin.new_goods.category.cate_list");
        echo json_encode(['code'=>200,'msg'=>'成功','data'=>$data],JSON_UNESCAPED_UNICODE);
    }
}
