@extends('bootstrap.admin')
@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        <h3>接口基础-商品修改</h3>
        <div class="form-group">
            <input type="text" class="form-control" style="width: auto" name="goods_name" placeholder="商品名称">
        </div>
        <div class="form-group">
            <input type="number" class="form-control" style="width: auto" name="goods_price" placeholder="商品价格">
        </div>
        <div class="form-group">
            <input type="file" id="file" class="form-control" style="width: auto" name="goods_img" placeholder="">
            {{--<button class="btn btn-danger upload">上传</button>--}}
            {{--<input type="button" value="上传" class="btn btn-danger upload">--}}
        </div>
        <div class="form-group">
            <img src="" id='img_show' width="150px">
        </div>

        <button type="button" class="save btn btn-success">修改</button>
    </form>
    <script>
        //获取url参数 不用php代码
        var goods_id = getUrlParam('goods_id');
        var url="http://www.dijiuyue.com/api/goods/restful";
        //    alert(user_id);
        //在页面中显示默认值
        $.ajax({
            url:url+"/"+goods_id,  //api/xxxx/2
            type:"GET",
            data:{goods_id:goods_id},
            dataType:"json",
            success:function(res){
                console.log(res);
//            alert(res.msg);
                $("[name='goods_name']").val(res.data.goods_name);
                $("[name='goods_price']").val(res.data.goods_price);
                $("#img_show").prop('src','/'+res.data.goods_img);
//                alert(res.data.goods_img);
            }
        });
        $("#file").on('change',function () {
               alert(1);
//            return;
            var fd= new FormData();
            var file=$("#file")[0].files[0];
//               console.log(file);return false;
            fd.append('goods_id',goods_id);
            fd.append('_method',"PUT");

            fd.append('file',file);
//                   alert(jjj);
            $.ajax({
                url:url+"/"+goods_id,
                type:"POST",
                data:fd,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function (res) {
                    console.log(res);

//                        alert('22');
//                        alert(res.img_url);
                        $("#img_show").prop('src','/'+res.img_url);



                }
            })
        });
        $(".save").on('click',function(){
            // alert(1);
            var goods_name=$("[name='goods_name']").val();
            var goods_price=$("[name='goods_price']").val();
            var fd= new FormData();
            var file=$("#file")[0].files[0];
//               console.log(file);return false;
            fd.append('_method',"PUT");

            fd.append('goods_name',goods_name);
            fd.append('goods_price',goods_price);
            //调用后台接口
            $.ajax({
                url:url+"/"+goods_id,
                type:"POST",
                data:fd,
                dataType:"json",
                contentType:false,
                processData:false,
                success:function(res){
                    alert(res.msg);
                    {{--if(res.code==200){--}}
                        {{--$("#img_show").prop('src','/'+res.img_url);--}}
                        {{--location.href="{{asset("/goods/goods_list")}}";--}}
                    {{--}--}}
                }
            });
        });

        //获取url中的参数
        function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
            if (r != null) return unescape(r[2]); return null; //返回参数值
        }

    </script>
@endsection