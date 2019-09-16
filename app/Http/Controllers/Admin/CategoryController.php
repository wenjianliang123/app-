<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods_category_model;

class CategoryController extends Controller
{
    public function add()
    {
        $data=Goods_category_model::get();

//        $data=$this->createTree($data);
        $data=$this->get_digui($data);
//        $data=json_decode(json_encode($data));
//        dd($data);
        return view("admin.new_goods.category.add",['data'=>$data]);
    }

    public function do_add(Request $request)
    {
        $data=$request->all();
//        dd($data);
        $cate_name=$request->all()['cate_name'];
        $parent_id=$request->all()['parent_id'];
//        dd($cate_name);
//        goods_category
        $result=Goods_category_model::insert([
            'cate_name'=>$cate_name,
            'parent_id'=>$parent_id,
        ]);
        if($result){
            echo json_encode(['code'=>200,'msg'=>'添加成功'],JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode(['code'=>500,'msg'=>'添加失败'],JSON_UNESCAPED_UNICODE);
        }

    }

    public function index()
    {
        $data=Goods_category_model::get()->toarray();
        $data=$this->get_digui($data);
        echo json_encode(['code'=>200,'msg'=>'成功','data'=>$data],JSON_UNESCAPED_UNICODE);
    }

    public static function get_digui($data,$parent_id=0,$level=0)
    {
        static $arr=[];
            /*if($data!=$data || !is_array($data)){
                return;
            }*/
            foreach ($data as $key=>$val)
            {
                if($val['parent_id']==$parent_id){
                    $val['level']=$level;
                    $arr[]=$val;
                    self::get_digui($data,$val['cate_id'],$level+1);
                }
            }

        return $arr;
    }


}
