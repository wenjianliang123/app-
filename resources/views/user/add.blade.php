<form action="" method="post" enctype="multipart/form-data">
    <h3>接口基础-用户添加</h3>
    <div class="form-group">
        <label for="exampleInputEmail1">用户名</label>
        <input type="text" class="form-control" name="user_name" placeholder="用户名">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">电话号</label>
        <input type="text" class="form-control" name="user_tel" placeholder="电话号">
    </div>
    <button type="button" class="btn btn-default sub">添加</button>
</form>
<script src="{{asset('/jquery-3.3.1.js')}} "></script>
<script>
    $(".sub").on('click',function(){
        // alert(1);
        var user_name=$("[name='user_name']").val();
        var user_tel=$("[name='user_tel']").val();
        var url="http://www.dijiuyue.com/api/user/restful";
        //调用后台接口
        $.ajax({
            url:url,
            type:"POST",
            data:{user_name:user_name,user_tel:user_tel},
            dataType:"json",
            success:function(res){
                alert(res.msg);
                if(res.code==200){
                    location.href="{{asset("/user/user_list")}}";
                }
            }
        });
    });
</script>