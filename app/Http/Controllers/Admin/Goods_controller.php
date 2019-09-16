<?php

namespace App\Http\Controllers\Admin;

use App\Model\Goods_attribute_model;
use App\Model\Goods_type_model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Goods_category_model;

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
    //获取属性值 （添加商品页面传回来的属性id）
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
