<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods_category_model;
use App\Model\Goods_model;

class CategoryController extends Controller
{
    //添加页面
    public function add()
    {
        $data=Goods_category_model::get();

//        $data=$this->createTree($data);
        $data=$this->get_digui($data);
//        $data=json_decode(json_encode($data));
//        dd($data);
        return view("admin.new_goods.category.add",['data'=>$data]);
    }
    //分类名称唯一性验证
    public function cate_name_unique_verufy(Request $request)
    {
        $cate_name=$request->all();
//        dd($cate_name);
        $cate_info=Goods_category_model::where('cate_name',$cate_name)->first();
        if(!empty($cate_info)){
            return json_encode(['code'=>707,'msg'=>'该分类名称已存在，请重新输入']);die();
        }else{
            return json_encode(['code'=>200,'msg'=>'该分类名称可用']);
        }
    }
    //执行添加
    public function do_add(Request $request)
    {
        $data=$request->all();
//        dd($data);
        $cate_name=$request->all()['cate_name'];
        $parent_id=$request->all()['parent_id'];
        $is_show=$request->all()['is_show'];
        $cate_sort=$request->all()['cate_sort'];
//        dd($cate_name);
//        goods_category
        $result=Goods_category_model::insert([
            'cate_name'=>$cate_name,
            'parent_id'=>$parent_id,
            'is_show'=>$is_show,
            'cate_sort'=>$cate_sort,
        ]);
        if($result){
            echo json_encode(['code'=>200,'msg'=>'添加成功'],JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode(['code'=>500,'msg'=>'添加失败'],JSON_UNESCAPED_UNICODE);
        }

    }
    //分类展示
    public function index()
    {
        $data=Goods_category_model::get()->toarray();

        foreach ($data as $key=> $v)
        {
            //思路
//            $a=1;//1查出来的数量
//            $data[0]['hh']=$aa;
//            $v['type_id'];
            $aa=Goods_model::where('cate_id',$v['cate_id'])->count();
//            dump($aa);
            $data[$key]['goods_count']=$aa;
        }

        $data=$this->get_digui($data);
        echo json_encode(['code'=>200,'msg'=>'成功','data'=>$data],JSON_UNESCAPED_UNICODE);

    }
    
    
    //实现无限极分类的递归方法（以后去学引用实现无限极）
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
