@extends('hadmin.admin')
@section('content')
    <h3>商品添加</h3>
    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="javascript:;" name='basic'>基本信息</a></li>
        <li role="presentation" ><a href="javascript:;" name='attr'>商品属性</a></li>
        <li role="presentation" ><a href="javascript:;" name='detail'>商品详情</a></li>
    </ul>
    <br>
    <center>
        <form  action='{{asset("admin/goods/goods_do_add")}}' method="POST" enctype="multipart/form-data" id='form'>
            @csrf
            <div class='div_basic div_form' align="center">
                <div class="form-group">
                    <label for="exampleInputEmail1">商品名称</label>
                    <input type="text" style="width: auto" class="form-control goods_name" name='goods_name'>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">商品分类</label>
                    <select class="form-control cate_id" style="width: auto;height: auto" name='cate_id'>
                        <option value="">请选择</option>
                        @foreach($cate_info as $k =>$v)
                            <option value="{{$v->parent_id}}">{{$v->cate_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">商品货号</label>
                    <input type="text" class="form-control" style="width: auto" name='goods_price'>
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">是否上架</label>
                    <input type="radio" class="on_sale" name='on_sale' value="1">上架
                    <input type="radio" class="on_sale" name="on_sale" value="2" checked>下架
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">商品价钱</label>
                    <input type="text" class="form-control" style="width: auto" name='goods_price'>
                </div>

                <div class="form-group">
                    <label for="exampleInputFile">商品图片</label>
                    <input type="file" class="btn btn-default goods_img" name='goods_img'>
                    <img src="" id="img_show" style="width: 295px;height: 180px" alt="">
                </div>
            </div>
            <div class='div_detail div_form' style='display:none'>
                <div class="form-group">
                    <label for="exampleInputFile">商品详情</label>
                    <!-- 加载编辑器的容器 -->
                    <script id="container" name="goods_description" type="text/plain">
                这里写你的初始化内容
                </script>
                </div>
            </div>
            <div class='div_attr div_form' style='display:none'>
                <div class="form-group">
                    <label for="exampleInputEmail1">商品类型</label>
                    <select class="form-control" style="width: auto;height: auto" name='type_id' >
                        <option>请选择</option>
                        @foreach($type_info as $k =>$v)
                            <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                        @endforeach
                    </select>
                </div>
                <br>

                <table width="100%" id="attrTable" style="margin-left: 350px" align="center" class='table table-bordered'>

                </table>
                <!-- <div class="form-group">
                        颜色:
                        <input type="text" name='attr_value_list[]'>
                </div> -->
                <!-- <div class="form-group" style='padding-left:26px'>
                    <a href="javascript:;">[+]</a>内存:
                    <input type="text" name='attr_value_list[]'>
                    属性价格:<input type="text" name='attr_price_list[][]'>
                </div> -->

            </div>

            <button type="submit" class="btn btn-default add_goods" id='btn'>添加</button>
        </form>
    </center>

    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    {{--富文本编辑器--}}
    <!-- 配置文件 -->
    <script type="text/javascript" src="{{asset('/ueditor/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{asset('/ueditor/ueditor.all.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>
    {{--富文本编辑器--}}
    <script type="text/javascript">
        //标签页 页面渲染
        $(".nav-tabs a").on("click",function(){
            $(this).parent().siblings('li').removeClass('active');
            $(this).parent().addClass('active');
            var name = $(this).attr('name');  // attr basic
            $(".div_form").hide();
            $(".div_"+name).show();  // $(".div_"+name)
        });

        //非空验证 阻止表单提交
        $(document).on('click','.add_goods',function (res) {
            var flag=false;
            var goods_name=$(".goods_name").val();
            var cate_id=$(".cate_id").val();
            if(goods_name==''||cate_id==''){
                flag=false;
            }else if(goods_name!=''&&cate_id!=''){
                flag=true;
            }
            if(flag){
                //允许添加
            }else{
                //阻止提交
                alert('商品名称、分类名称必填');
                return false;
            }



        });

        //图片预览
        var base64Str;//这里定义 下面赋值 之后全局可调用
        var file_name;
        var file_size;
        var file_type;
        $(".goods_img").on('change',function(){
            //模拟表单对象  FormData
            var file = $('[name="goods_img"]')[0].files[0]; //获取到文件
//        console.log(file);return;
            file_name=file.name;
            file_size=file.size;
            file_type=file.type;
            var reader = new FileReader(); //h5
            reader.readAsDataURL(file); //读base编码后的url地址
            reader.onload = function()
            {
                base64Str = this.result;
//            console.log(this.result);
                $("#img_show").attr('src',this.result);
            }
        });

        //点击类型时出现对应属性
        $("[name='type_id']").on('change',function(){
           //获取被选中的select中的val值
            var type_id=$(this).val();
//            alert(type_id);
            //根据type_id查下面的属性
            $.ajax({
               url:'http://www.dijiuyue.com/admin/goods/getAttr',
                data:{type_id:type_id},
                dataType:'json',
                success:function(res){
                    console.log(res);
                    $("#attrTable").empty();

                    //res有几个数据就在变革中添加几个tr
                    $.each(res,function (i,v) {
                        if(v.attribute_is==1){
                            //不可选属性
                            var tr='<tr>\
                                <td>'+v.attribute_name+'</td>\
                                <td>\
                                    <input type="hidden" name="attr_id_list[]" value="'+v.attribute_id+'">\
                                    <input name="attr_value_list[]" type="text" value="" size="20">\
                                    <input type="hidden" name="attr_price_list[]" value="0">\
                                </td>\
                            </tr>';
                        }else{
                            //可选属性
                            var tr='<tr>\
                                <td>\
                                <a href="javascript:;" class="addRow">[+]</a>'+v.attribute_name+'</td>\
                                <td>\
                                <input type="hidden" name="attr_id_list[]" value="'+v.attribute_id+'">\
                                <input name="attr_value_list[]" type="text" value="" size="20">\
                                属性价格 <input type="text" name="attr_price_list[]" value="" size="5" maxlength="10">\
                                </td>\
                                </tr>';
                        }
                        $("#attrTable").append(tr);
                    })
                }
            });
        });

        //点击+ -号
        $(document).on('click','.addRow',function () {

            var val=$(this).html();
            if(val == "[+]"){
                //jquery clone 复制当前
                //复制之前 先把+变为-
                $(this).html("[-]");
                var tr_clone=$(this).parent().parent().clone();
                $(this).parent().parent().after(tr_clone);
                //复制之后 再把-变为+
                $(this).html("[+]");
            }else{
                $(this).parent().parent().remove();
            }

        })

    </script>
@endsection