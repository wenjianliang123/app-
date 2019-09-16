<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods_type_model;
use App\Model\Goods_attribute_model;

class TypeController extends Controller
{
    public function add()
    {
        return view("admin.new_goods.type.add");
    }

    public function do_add(Request $request)
    {
        $type_name=$request->all();
//        dd($type_name);
//        goods_category
        $result=Goods_type_model::insert([
            'type_name'=>$type_name,
        ]);
        if($result){
            echo json_encode(['code'=>200,'msg'=>'添加成功'],JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode(['code'=>500,'msg'=>'添加失败'],JSON_UNESCAPED_UNICODE);
        }

    }

    public function index()
    {
        $data=Goods_type_model::get()->toarray();

        foreach ($data as $key=> $v)
        {
            //思路
//            $a=1;//1查出来的数量
//            $data[0]['hh']=$aa;
//            $v['type_id'];
            $aa=Goods_attribute_model::where('type_id',$v['type_id'])->count();
//            dump($aa);
            $data[$key]['attr_count']=$aa;
        }

//        dd();
//        dd($data);
//        return view("admin.new_goods.category.cate_list");
        echo json_encode(['code'=>200,'msg'=>'成功','data'=>$data],JSON_UNESCAPED_UNICODE);
    }
}
