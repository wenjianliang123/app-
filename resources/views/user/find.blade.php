<form action="" method="post" enctype="multipart/form-data">
    <h3>接口基础-用户修改</h3>
    <div class="form-group">
        <label for="exampleInputEmail1">用户名</label>
        <input type="text" class="form-control" name="user_name" placeholder="用户名">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">电话号</label>
        <input type="text" class="form-control" name="user_tel" placeholder="电话号">
    </div>
    <button type="button" class="btn btn-default save">修改</button>
</form>
<script src="{{asset('/jquery-3.3.1.js')}} "></script>
<script>
    //获取url参数 不用php代码
    var user_id = getUrlParam('user_id');
    var url="http://www.dijiuyue.com/api/user/restful";
//    alert(user_id);
    //在页面中显示默认值
    $.ajax({
        url:url+"/"+user_id,  //api/xxxx/2
        type:"GET",
        data:{user_id:user_id},
        dataType:"json",
        success:function(res){
            console.log(res);
//            alert(res.msg);
            $("[name='user_name']").val(res.data.user_name);
            $("[name='user_tel']").val(res.data.user_tel);
        }
    });
    $(".save").on('click',function(){
        // alert(1);
        var user_name=$("[name='user_name']").val();
        var user_tel=$("[name='user_tel']").val();
        //调用后台接口
        $.ajax({
            url:url+"/"+user_id,
            type:"POST",
            data:{_method:"PUT",user_name:user_name,user_tel:user_tel},
            dataType:"json",
            success:function(res){
                alert(res.msg);
                if(res.code==200){
                    location.href="{{asset("/user/user_list")}}";
                }
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