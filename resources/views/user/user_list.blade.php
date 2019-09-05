<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h3>接口基础-用户展示</h3>
<input type="text" name="user_name" >
<input type="submit" value="搜索">
<table border="1">
    <tr>
        <td>Id</td>
        <td>姓名</td>
        <td>电话</td>
        <td>操作</td>
    </tr>
    <tbody class="add">

    </tbody>
</table>
    <div name="pagination" class="pagination">

    </div>
</body>
</html>
<script src="{{asset('/jquery-3.3.1.js')}}"></script>
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

    //ajax搜索
    /**
     * 点击搜索按钮
     * 获取搜索内容
     * 发送ajax请求后台接口
     * 渲染页面
     */
    $("[type=submit]").click(function () {
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
        $(".add").empty();
        $.each(res.data.data,function(i,v){
            //定义一个空tr
            var tr=$("<tr></tr>");
            //往tr里面内部后面追加
            tr.append("<td>"+v.user_id+"</td>");
            tr.append("<td>"+v.user_name+"</td>");
            tr.append("<td>"+v.user_tel+"</td>");
            tr.append("<td>" +
                "<a href='javascript:;' class='del' user_id='"+v.user_id+"'>删除</a>" +
                "&nbsp||&nbsp" +
                "<a href='javascript:;' class='find' user_id='"+v.user_id+"'>修改</a></td>");
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
                page+="<a href='javascript:;' style='color:#D50000' page='"+i+"'>第"+i+"页</a>";
            }else{
                page+="<a href='javascript:;' page='"+i+"'>第"+i+"页</a>";
            }
        }
        //填入空白div 生成页码链接
        $("[name=pagination]").html(page);
    }
</script>