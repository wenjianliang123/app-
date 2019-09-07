@extends('bootstrap.admin')
@section('content')
<h3>接口基础-用户展示</h3>
<div class="rgba">
    <form class="form-inline" >
        <div class="form-group">
            <label class="sr-only" for="exampleInputEmail3">Email address</label>
            <input type="text"  name="user_name" class="form-control" style="width: auto;background-color: rgba(0,0,0,0.1);">
        </div>
        <input type="button" style="" value="搜索" class="search btn btn-info">
    </form>

    <table class="table table-striped" style="cellspacing:0;cellpadding:0">
        <tr style="background-color: rgba(0,0,0,0.1);">
            <td>Id</td>
            <td>姓名</td>
            <td>电话</td>
            <td>操作</td>
        </tr>
        <tbody class="add">

        </tbody>
    </table>
    {{--<div name="pagination" class="pagination">--}}

    {{--</div>--}}

    <nav aria-label="Page navigation" >
        <ul class="pagination">
            <li>
                <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
                <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>


<script>
    //定义一个地址 以后方便更改
    var url="http://www.dijiuyue.com/api/user/restful";
    //进入页面渲染
    $.ajax({
        url:url,
        type:"GET",
        dataType:'json',
        success:function(res){
            wjl_page(res)
        },
    });
    //点击删除调用restful DELETE请求 进行删除操作
    $(document).on('click','.del',function(){
        var user_id = $(this).attr('user_id');
//        _this=$(this);这一步不能再ajax里面进行操作
        _this=$(this);
        $.ajax({
            url:url+"/"+user_id,
            type:"delete",
            data:{user_id:user_id},
            dataType:'json',
            success:function(res){
                alert(res.msg);
                _this.parent().parent().remove();
            },
        });
    });
    //点击修改按钮 携带id跳转去修改查询页面
    $(document).on('click','.find',function(){
        var user_id = $(this).attr('user_id');
            location.href="http://www.dijiuyue.com/user/find?user_id="+user_id;
    });

    //ajax搜索 搜索结果高亮
    /**
     * 点击搜索按钮
     * 获取搜索内容
     * 发送ajax请求后台接口
     * 渲染页面
     */
    $(".search").click(function () {
        var user_name=$("[name=user_name]").val();
//        alert(user_name);
        $.ajax({
            url:url,
            type:"GET",
            data:{user_name:user_name},
            dataType:'json',
            success:function(res){
                wjl_page(res)
            },
        });

    })

    //ajax分页
    /**
     * 点击分页按钮
     * 获取分页页码
     * 发送ajax请求到后台接口
     * 渲染页面
     */
    $(document).on("click",".pagination a",function(){
        var page=$(this).attr("page");
        var user_name=$("[name=user_name]").val();
//        alert(user_name);
        $.ajax({
            url:url,
            type:"GET",
            data:{page:page,user_name:user_name},
            dataType:'json',
            success:function(res){
                wjl_page(res)
            },
        });

    })

    //封装的刷新页面、构建页码
    function wjl_page(res) {
        var user_name=$("[name=user_name]").val();
        $(".add").empty();
        var str='';//简单定义一个str容器 //容器：仅是为了定义 实际为空
        var name_arr='';//定义一个用户名容器
        var span="<span style='color: #D50000;'></span>";//定义一个空白的span
        var sub_length=span.length+user_name.length;//计算span标签和搜索值的长度
        var sub_slice='';//定义截取容器
        $.each(res.data.data,function(i,v){
            //定义一个空tr
            var tr=$("<tr style='background-color: rgba(0,0,0,0.1);'></tr>");
            //往tr里面内部后面追加
            tr.append("<td>"+v.user_id+"</td>");
            //判断是否在搜索
            if(user_name!=''){
                str='';//循环后重新清空
                name_arr = v.user_name.split(user_name);//字符串分割 和explode分割数组原理差不多  //这一步就是 问建梁123分割为就是 ''.123 空白部分就是搜索值
//                    console.log(str);
                $.each(name_arr,function(key,value){
                    str+=value+"<span style='color: #D50000'>"+user_name+"</span>";
                    //问建梁123 value就是123 span包着的就是红色的问建梁
                });
                sub_slice= str.slice(0,-sub_length+1);//截取倒着数问建梁123但是后面的123少一位 所以加一  倒着数就是不管问建梁前面还是后面都能避免遗漏

                tr.append("<td>"+sub_slice+"</td>");
            }else{
                tr.append("<td>"+v.user_name+"</td>");
            }

            tr.append("<td>"+v.user_tel+"</td>");
            tr.append("<td>" +
                "<a href='javascript:;' class='del btn btn-danger'  user_id='"+v.user_id+"'>删除</a>" +
                "&nbsp||&nbsp" +
                "<a href='javascript:;' class='find btn btn-success' user_id='"+v.user_id+"'>修改</a></td>");
            //填入空白tbody
            $(".add").append(tr);
        });
        //构建页码
        var page="";
        // 根据页面返回的last_page参数循环  last_page是一共多少页
        for (var i=1;i<=res.data.last_page;i++)
        {
            //current_page是当前页
            if(i==res.data.current_page){
                page+="<li class='active'><a href='javascript:;' style='color: #7adddd' page='"+i+"'>第"+i+"页</a></li>";
            }else{
                page+="<li style=''><a href='javascript:;' page='"+i+"'>第"+i+"页</a></li>";
            }
        }
        //填入空白div 生成页码链接
        $(".pagination").html(page);
    }
</script>
@endsection
