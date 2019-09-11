<?php

namespace App\Http\Controllers\Api;

use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Upload\UploadController;
use App\Http\Tool\Aes;

class GoodsController extends Controller
{
    /**
     * @var UploadController
     * 上传、上传删除、商品管理、ajax后台搜索结果高亮
     *
     */
    public $UploadController;
    public function __construct(UploadController $UploadController)
    {
        $this->UploadController=$UploadController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * 展示+（缓存展示+多条件搜索+分页）
     */
    public function index(Request $request)
    {
//        echo phpinfo();die();
        $redis= new \Redis();
        $redis->connect("127.0.0.1",'6379');
        //清除所有的redis数据
//        dd($redis->flushall());
        //前台传回来的搜索内容
        $search_info=$request->input("goods_name");
        //前台传回来的页码 用于缓存+分页
        $page=$request->input("page");
//        dd($page);
        //定义一个redis键
        $redis_key="goods_infomation_".$search_info.$page;
//        dd(1);
        $redis_data_1='';
        $redis_data_1=$redis->get($redis_key);
//        dd($redis_data_1);
        if(!empty($redis_data_1)){
              $data=$redis->get($redis_key);
              $data=json_decode($data,1);
//              $dd[]='问建梁';
//            dd($data['ss']=$dd);
        }else{
//        dd($goods_name);
            //多条件搜索 ajax搜索结果高亮
            $where=[];
            $OrWhere=[];
            if ($search_info!=='NULL'){
                $where[]=['goods_name','like',"%$search_info%"];
            }elseif ($search_info!=='NULL'){
                $OrWhere[]=['goods_price','like',"%$search_info%"];
            }
            $data =GoodsModel::where($where)->orwhere($OrWhere)->paginate(2)->toArray();
//          dd($data);

            $redis_data=json_encode($data);
            $redis->set('goods_infomation_'.$search_info.$page,$redis_data,180);
//            dd($data);
        }

        //ajax搜索结果高亮
        if($search_info!=='NULL'){
            foreach ($data['data'] as $k =>$v)
            {
                $data['data'][$k]['goods_name']=str_replace($search_info,"<b style='color:red'>".$search_info."</b>",$v['goods_name']);
                $data['data'][$k]['goods_price']=str_replace($search_info,"<b style='color:red'>".$search_info."</b>",$v['goods_price']);
            }
        }

        return json_encode(['code'=>'200','data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.goods.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $goods_name_price_info=$_POST;
        $goods_img_info=$_FILES['goods_img'];
//        dd($goods_img_info);
        $goods_name=$goods_name_price_info['goods_name'];
        $goods_price=$goods_name_price_info['goods_price'];
//        dd($goods_name);
        //调用自己写的 UploadController里面的form-data上传方法
        $goods_img_url=$this->UploadController->upload($goods_img_info);


        //Aes数据加密
        $obj = new Aes('wenjianliang');
        $url = [
            'goods_name'=>$goods_name,
            'goods_price'=>$goods_price,
            'goods_img'=>$goods_img_url,
        ];
//        echo $eStr = $obj->encrypt($url);
//        echo "<hr>";
//        echo $newStr = $obj->decrypt($eStr);die;
//        echo "<hr>";
        $url=$obj->encrypt(serialize($url));
//        dd($url);
        //unserialize($obj->decrypt($url))
        $result=GoodsModel::insert(unserialize($obj->decrypt($url)));
//        dd($result);
//        return;
        if ($result){
            echo "添加成功";
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($goods_id)
    {
        if (empty($goods_id)){
            return json_encode(['code'=>400,'msg'=>'商品ID参数不能为空']);
        }
        $data=GoodsModel::where('goods_id',$goods_id)->first();
        return json_encode(['code'=>'200','data'=>$data]);
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
    public function update(Request $request, $goods_id)
    {
        $redis= new \Redis();
        $redis->connect("127.0.0.1",'6379');


        //接受传回来的商品名称、价格
        $goods_name=$request->input("goods_name");
        $goods_price=$request->input("goods_price");
        //定义是否有文件
        $file=$request->file('file');
        //无图 有id 有名称 有价格
        if (!isset($file) && $goods_id!='' && $goods_name!=''&&$goods_price!=''){
            $GoodsModel = GoodsModel::find($goods_id);
                $GoodsModel->goods_name = $goods_name;
                $GoodsModel->goods_price = $goods_price;
                $result=$GoodsModel->save();
                if($result){
                    //清除所有的redis数据
                    $redis->flushall();
                    return json_encode(['code'=>666,'msg'=>'修改商品名称、商品价格成功']);
                }
        }elseif(isset($file) && $goods_id!='' && $goods_name!=''&&$goods_price!=''){
            //有图 有id 有名称 有价格
            $path = $request->file('file')->store('image/'.date("Y-n-j"));

            $GoodsModel = GoodsModel::find($goods_id);
            //这先定义原来数库的图片地址 否则下面修改后img再赋值的话 与$path新上传的图片地址一比较就会一样
            $img_url=$GoodsModel->goods_img;
            $GoodsModel->goods_name = $goods_name;
            $GoodsModel->goods_price = $goods_price;
            $GoodsModel->goods_img = $path;
            $result=$GoodsModel->save();
            if($result){
//                dump($img_url);
//                dump($path);die();
                //清除所有的redis数据
                $redis->flushall();
                if($img_url!==$path){
                    //@错误屏蔽符 如果删除不存在的文件会报错 屏蔽掉就好了
                    $aa=@unlink("./".$img_url);//删除当前项目目录下的图片
//                    dd($aa);
                }
                return json_encode(['code'=>666,'msg'=>'修改图片加名称加价格成功']);
            }
//


        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $goods_id=$request->all();
//        dd($user_id);
        $goods_img_url=GoodsModel::where(['goods_id'=>$goods_id])->first()->toarray();
        $goods_img_url=json_decode(json_encode($goods_img_url),1)['goods_img'];
//        dd($goods_img_url);
        //删除图片 ./image/2019-9-9/xcehvcsxghhgbfvdcscd.jpg
        @unlink("$goods_img_url");
        $res= GoodsModel::where(['goods_id'=>$goods_id])->delete();
        if($res){
            return json_encode(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'删除失败,程序异常,请联系管理员']);
        }
    }
}
