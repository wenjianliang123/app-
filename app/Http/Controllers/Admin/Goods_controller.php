<?php

namespace App\Http\Controllers\Admin;

use App\Model\Goods_attribute_model;
use App\Model\Goods_model;
use App\Model\Goods_type_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods_category_model;
use App\Model\Goods_Attr_relation;
use App\Model\SKU_model;

class Goods_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //添加商品页面
    public function add()
    {
        $cate_info=Goods_category_model::get();
        $type_info=Goods_type_model::get();
        return view("admin.new_goods.goods.add",[
            'cate_info'=>$cate_info,
            'type_info'=>$type_info
        ]);
    }

    /**
     * @param Request $request
     * @return string
     * 获取属性值 （添加商品页面传回来的属性id）
     * 用于选择商品类型时出现对应的商品属性
     */
    public function getAttr(Request $request)
    {
        $type_id=$request->all();
//        dd($type_id);
        $attrData=Goods_attribute_model::where('type_id',$type_id)->get()->toarray();
//        dd($attrData);
        return json_encode($attrData);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //商品执行添加 关键 接值 入商品表（返回的是一个对象） 再循环入商品属性表
    public function store(Request $request)
    {
//        dd(1);
        $postData=$request->all();
//        dd($postData);
//        dd($request->file('goods_img'));
        //文件上传
        //判断是否上传文件
        if($request->file('goods_img')!=''){
            $date=date('Y-n-j',time());
//        dd($date);
            $goods_img_path = $request->file('goods_img')->store('image/'.$date);
//            dd($goods_img_path);
            //入商品库
            $goods_data=Goods_model::create([
                'goods_name'=>$postData['goods_name'],
                'cate_id'=>$postData['cate_id'],
                'goods_price'=>$postData['goods_price'],
                'goods_img'=>$goods_img_path,
                'on_sale'=>$postData['on_sale'],
                'goods_description'=>$postData['goods_description'],
            ]);//返回的是一个包含商品ID的对象
        }else{
//            dd(1);
            //入商品库
            $goods_data=Goods_model::create([
                'goods_name'=>$postData['goods_name'],
                'cate_id'=>$postData['cate_id'],
                'goods_price'=>$postData['goods_price'],
                'on_sale'=>$postData['on_sale'],
                'goods_description'=>$postData['goods_description'],
            ]);//返回的是一个包含商品ID的对象
        }

//        return $goods_img_path;


//        dd($postData);


        //商品id是对象的返回来的
       $goods_id=$goods_data->goods_id;
       //效率慢的添加： 循环多次 添加多次
        /*foreach ($postData['attr_id_list'] as $k =>$v) {
            if($postData['attr_value_list'][$k]!=''){
                $goods_attr_relation_Data = Goods_Attr_relation::create([
                    'goods_id' => $goods_id,
                    'attr_id' => $v,
                    'attr_value' => $postData['attr_value_list'][$k],
                    'attr_price' => $postData['attr_price_list'][$k],
                ]);
            }
        }
                dd($goods_attr_relation_Data);*/
        //效率高一点的添加 只循环查询一次 只添加一次
        $goods_attr_relation_Data=[];
        if(!empty($postData['attr_id_list'])){
            foreach ($postData['attr_id_list'] as $k =>$v) {
                //不为空 （属性值为空 停止入库）
                if($postData['attr_value_list'][$k]!=''){
                    $goods_attr_relation_Data[]=[
                        'goods_id' => $goods_id,
                        'attr_id' => $v,
                        'attr_value' => $postData['attr_value_list'][$k],
                        'attr_price' => $postData['attr_price_list'][$k],
                    ];
                }
            }
        }

        $goods_attr_relation_Data_1 = Goods_Attr_relation::insert($goods_attr_relation_Data);
//        dd($goods_attr_relation_Data_1);
        //跳转到库存页面
//dd(1);

        echo "<script>function yourConfirm(goods_id){
        if (confirm('是否去添加货品 取消则会跳转去商品列表?')) {
            window.location.href = 'http://www.dijiuyue.com/admin/goods/goods_sku/'+goods_id;
        }else{
            location.href='http://www.dijiuyue.com/admin/goods/goods_list';
        }
    }</script>";
        echo "<center><a href=\"javascript:;\" onclick='yourConfirm(\"{$goods_id}\")'>添加商品成功 请选择下一步操作</a></center>";


//        dd(111);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //货品添加页面
    public function sku($goods_id)
    {
//        dd($goods_id);
        //通过商品id查询商品表
        $goods_data=Goods_model::where(['goods_id'=>$goods_id])->first()->toarray();
        $goods_data=json_decode(json_encode($goods_data),1);
//        dd($goods_data);
        //通过商品id两表联查 商品属性关系表——属性表
        $goods_attr_relation_and_goods_attr_info = Goods_Attr_relation::join(
                                    'goods_attribute','goods_attr_relation.attr_id','=','goods_attribute.attribute_id')->where(['goods_attr_relation.goods_id'=>$goods_id,'attribute_is'=>2]
        )->get()->toarray();
//        dd($goods_attr_relation_and_goods_attr_info);
        //根据attr_id进行分组 使其成为 内存['0'=>16G,'1'=>'32G'],颜色['0'=>red,'1'=>blue]
        $new_attr_arr=[];
        foreach ($goods_attr_relation_and_goods_attr_info as $k=>$v) {
            $new_attr_arr[$v['attr_id']][]=$v;
        }
//        dd($new_attr_arr);
        //给视图传值
        return view("admin.new_goods.goods.sku",[
            'goods_info'=>$goods_data,
            'attr_info'=>$new_attr_arr,
            'goods_id'=>$goods_id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //货品执行添加
    public function sku_do_add(Request $request)
    {
        $attr_and_sku_data=$request->all();
//        dd($attr_and_sku_data);
        //计算如何分割数组
        if(!empty($attr_and_sku_data['attr_id_list'])){
            $size=count($attr_and_sku_data['attr_id_list']) / count($attr_and_sku_data['product_number']);

//        dd($size);
            //分割数组
//        dd($attr_and_sku_data['attr_id_list']);
            $attr_id_list_info=array_chunk($attr_and_sku_data['attr_id_list'],$size);
//            dd($attr_id_list_info);
            //循环入库
            $insert_data=[];
            foreach ($attr_id_list_info as $k=>$v){
                $insert_data[]=[
                    'goods_id'=>$attr_and_sku_data['goods_id'],
                    'attr_value_list'=>implode(',',$v),
                    'sku'=>$attr_and_sku_data['product_number'][$k],
                ];
            }
            $result=SKU_model::insert($insert_data);
            if($result){
                echo "<script> alert('货品添加成功，即将跳转去商品列表');window.location.href='http://www.dijiuyue.com/admin/goods/goods_list'; </script>";
            }else{
                echo "<script> alert('货品添加失败');window.history.go(-1); </script>";
            }
//            dd($result);
        }else{
            $insert_data=[];
//            dd($attr_and_sku_data['product_number']);
                $insert_data[]=[
                    'goods_id'=>$attr_and_sku_data['goods_id'],
                    'sku'=>implode($attr_and_sku_data['product_number']),
                ];
            $result=SKU_model::insert($insert_data);
//            dd($result);
            if($result){
                echo "<script> alert('货品添加成功，即将跳转去商品列表');window.location.href='http://www.dijiuyue.com/admin/goods/goods_list'; </script>";
            }else{
                echo "<script> alert('货品添加失败');window.history.go(-1); </script>";
            }
        }

//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd($request->all());
        $goods_name=$request->goods_name;
        $cate_id=$request->cate_id;
        $on_sale=$request->on_sale;
//        dd($on_sale);
//        dd($cate_id);
//        dd($goods_name);
        $where=[];
//        $OrWhere=[];
        if (!empty($goods_name)){
//            dd($goods_name);
            $where[]=['goods_name','like',"%$goods_name%"];
        }
        if (!empty($cate_id)){
//            dd($cate_id);
            $where[]=['cate_id','=',$cate_id];
        }
        if (!empty($on_sale)){
//            dd($on_sale);
            $where[]=['on_sale','=',$on_sale];
        }
//        dd($where);
//        dd();
        $data=Goods_model::where($where)->paginate(3)->toarray();
//        $data=Goods_model::where($where)->get()->toarray();
//        dd($data['data'][2]['on_sale']);
        //如果on_sale=1 已上架 否则未上架
        $a='';
        foreach ($data['data'] as $k=>$v){
//            dump($k);
            if($v['on_sale']==1){
                $a="🏒";
//                $a="🏒";
//                $a="<b style='color: green;'>✔</b>";
            }else{
//                $a='×';
//                $a="<b style='color: red;'>✖</b>";
                $a="❌";
            }
//            dump($data[$k]['on_sale']);die;
//            dump($k);die;
            $data['data'][$k]['on_sale']=str_replace($v['on_sale'],$a,$v['on_sale']);
        }
//        dd();

        return json_encode(['code'=>200,'msg'=>'成功','data'=>$data],JSON_UNESCAPED_UNICODE);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function goods_list()
    {
        //搜索时用到的分类信息
        $cate_info=Goods_category_model::get()->toarray();
        return view('admin.new_goods.goods.goods_list',['cate_info'=>$cate_info]);
    }
    //商品名称即点即改
    public function goods_jidianjigai(Request $request)
    {
        $goods_name=$request->goods_name;
        $goods_id=$request->goods_id;
//        dd($goods_name);
//        dd($goods_id);
        if(!empty($goods_id)&&!empty($goods_name))
        {
            $GoodsModel = Goods_model::find($goods_id);
            $GoodsModel->goods_name = $goods_name;
            $result=$GoodsModel->save();
            if($result){
                echo 2;
            }else{
                echo 1;
            }
        }else{
            echo 1;
        }
    }

    //上架即点即改
    /*public function goods_jidianjigai_1(Request $request)
    {
        $goods_name=$request->on_sale;
        $goods_id=$request->goods_id;
//        dd($goods_name);
//        dd($goods_id);
        if(!empty($goods_id)&&!empty($goods_name))
        {
            $GoodsModel = Goods_model::find($goods_id);
            $GoodsModel->on_sale = $goods_name;
            $result=$GoodsModel->save();
            if($result){
                echo 2;
            }else{
                echo 1;
            }
        }else{
            echo 1;
        }
    }*/
    public function goods_jidianjigai_1(Request $request)
    {
        $goods_id=$request->goods_id;
//        dd($goods_id);
        //查询goods_id的对应的上架信息
        $on_sale=Goods_model::where('goods_id',$goods_id)->value('on_sale');
//        dd($on_sale);
        if($on_sale==1){
            $GoodsModel = Goods_model::find($goods_id);
            $GoodsModel->on_sale = 2;
            $result=$GoodsModel->save();
            if($result){
                return json_encode(['code'=>200,'msg'=>'已下架']);
            }else{
                return json_encode(['code'=>500,'msg'=>'上下架修改失败']);
            }
        }else if($on_sale==2){
            $GoodsModel = Goods_model::find($goods_id);
            $GoodsModel->on_sale = 1;
            $result=$GoodsModel->save();
            if($result){
                return json_encode(['code'=>200,'msg'=>'已上架']);
            }else{
                return json_encode(['code'=>500,'msg'=>'上下架修改失败']);
            }
        }
    }
}
