@extends('hadmin.admin')
@section('content')
    <h3>分类展示</h3>
    <div class="rgba">
        <table class="table table-striped" style="">
            <tr style="background-color: rgba(0,0,0,0.1);">
                <td>Id</td>
                <td>分类名称</td>
                <td>该分类下商品数量</td>
                <td>操作</td>
            </tr>
            <tbody class="cate_add">
            
            </tbody>
        </table>
    </div>
    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <script>
        //定义一个地址 以后方便更改
        var url="http://www.dijiuyue.com/admin/goods/cate_index";
        //进入页面渲染
        $.ajax({
            url:url,
            type:"GET",
            dataType:'json',
            success:function(res){
                wjl_page(res)
            },
        });
        //js 自己找的 重复字符串
        function repeat(str , n){
            return new Array(n+1).join(str);
        }
        //封装的刷新页面、构建页码 ajax搜索结果高亮
        function wjl_page(res) {
            var cate_name=$("[name=cate_name]").val();
            $(".cate_add").empty();
            $.each(res.data,function(i,v){
                //定义一个空tr
                var tr=$("<tr style='background-color: rgba(0,0,0,0.1);'></tr>");
                //往tr里面内部后面追加
                tr.append("<td>"+v.cate_id+"</td>");
                tr.append("<td>"+repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",v.level)+v.cate_name+"</td>");
                tr.append("<td>"+v.goods_count+"</td>");
                tr.append("<td>" +
                    "<a href='javascript:;' class='del btn btn-danger'  cate_id='"+v.cate_id+"'>删除</a>" +
                    "&nbsp||&nbsp" +
                    "<a href='javascript:;' class='find btn btn-success' cate_id='"+v.cate_id+"'>修改</a></td>");
                //填入空白tbody
                $(".cate_add").append(tr);
            });
        }
    </script>
@endsection

