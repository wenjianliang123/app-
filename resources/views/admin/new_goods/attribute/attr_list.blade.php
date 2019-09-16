@extends('hadmin.admin')
@section('content')
    <h3>分类展示</h3>
    <div class="rgba">
        <table class="table table-striped" style="">
            <tr style="background-color: rgba(0,0,0,0.1);">
                <td>Id</td>
                <td>属性名称</td>
                <td>商品类型</td>
                <td>操作</td>
            </tr>
            <tbody class="cate_add">

            </tbody>
        </table>
        {{--<div name="pagination" class="pagination">--}}

        {{--</div>--}}


    </div>


    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <script>
        //定义一个地址 以后方便更改
        var url="http://www.dijiuyue.com/admin/goods/attr_index";
        //进入页面渲染
        $.ajax({
            url:url,
            type:"GET",
            dataType:'json',
            success:function(res){
                wjl_page(res)
            },

        });




        //ajax分页
        /**
         * 点击分页按钮
         * 获取分页页码
         * 发送ajax请求到后台接口
         * 渲染页面
         */
        $(document).on("click",".pagination a",function(){
            var page=$(this).attr("page");
//        alert(user_name);
            $.ajax({
                url:url,
                type:"GET",
                data:{page:page},
                dataType:'json',
                success:function(res){
                    wjl_page(res)
                },
            });

        })

        //封装的刷新页面、构建页码 ajax搜索结果高亮
        function wjl_page(res) {
            var attribute_name=$("[name=attribute_name]").val();
            var type_id=$("[name=type_id]").val();
            $(".cate_add").empty();
            $.each(res.data,function(i,v){
                //定义一个空tr
                var tr=$("<tr style='background-color: rgba(0,0,0,0.1);'></tr>");

                //往tr里面内部后面追加
                tr.append("<td>"+v.attribute_id+"</td>");
                tr.append("<td>"+v.attribute_name+"</td>");
                tr.append("<td>"+v.type_name+"</td>");
                tr.append("<td>" +
                    "<a href='javascript:;' class='del btn btn-danger'  attribute_name='"+v.attribute_name+"'>删除</a>" +
                    "&nbsp||&nbsp" +
                    "<a href='javascript:;' class='find btn btn-success' attribute_name='"+v.attribute_name+"'>修改</a></td>");
                //填入空白tbody
                $(".cate_add").append(tr);
            });

        }
    </script>
@endsection

