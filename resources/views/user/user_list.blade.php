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
</body>
</html>
<script src="{{asset('/jquery-3.3.1.js')}}"></script>
<script>
    $.ajax({
        url:"http://www.dijiuyue.com/api/user/user_list",
        dataType:'json',
        success:function(res){
            console.log(res);
            $.each(res.data,function(i,v){
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
        },
    });
    $(document).on('click','.del',function(){
        var user_id = $(this).attr('user_id');
        _this=$(this);
        $.ajax({
            url:"http://www.dijiuyue.com/api/user/user_del",
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
</script>