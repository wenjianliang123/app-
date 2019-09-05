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
    var url="http://www.dijiuyue.com/api/user/restful";
    $.ajax({
        url:url,
        type:"GET",
        dataType:'json',
        success:function(res){
            wjl_page(res)
        },
    });
    $(document).on('click','.del',function(){
        var user_id = $(this).attr('user_id');
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

    $(document).on('click','.find',function(){
        var user_id = $(this).attr('user_id');
            location.href="http://www.dijiuyue.com/user/find?user_id="+user_id;
    });

    //ajax搜索

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
        /*//构建页码
        var page="";
        for (var i=1;i<=res.data.data.last_page;i++)
        {
            page+="<a href='javascript:;' page='"+i+"'>第"+i+"页</a>";
        }
        $("[name=pagination]").html(page);*/
    })

    //封装的刷新页面、构建页码
    function wjl_page(res) {
        $(".add").empty();
        $.each(res.data.data,function(i,v){
            var tr=$("<tr></tr>");
            tr.append("<td>"+v.user_id+"</td>");
            tr.append("<td>"+v.user_name+"</td>");
            tr.append("<td>"+v.user_tel+"</td>");
            tr.append("<td>" +
                "<a href='javascript:;' class='del' user_id='"+v.user_id+"'>删除</a>" +
                "&nbsp||&nbsp" +
                "<a href='javascript:;' class='find' user_id='"+v.user_id+"'>修改</a></td>");
            $(".add").append(tr);
        });
        //构建页码
        var page="";
        for (var i=1;i<=res.data.last_page;i++)
        {
            if(i==res.data.current_page){
                page+="<a href='javascript:;' style='color:#D50000' page='"+i+"'>第"+i+"页</a>";
            }else{
                page+="<a href='javascript:;' page='"+i+"'>第"+i+"页</a>";
            }
        }
        $("[name=pagination]").html(page);
    }
</script>