@extends("bootstrap.admin")
@section('content')
    <form action="" class="form-group">
        <table align="center">
            <tr>
                <td>
                    <label for="exampleInputEmail1">用户名</label>
                </td>
                <td>
                    <input class="form-control user_name" type="text" name="user_name">
                </td>
            </tr>
            <tr>
                <td><label for="exampleInputEmail1">密码</label></td>
                <td>
                    <input class="form-control user_pwd" type="text" name="user_pwd">
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <input type="button" style="margin-left: 60px" align="center" class="btn btn-info do_login" value="登录">
                </td>
            </tr>
        </table>
    </form>
    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('/public.js')}}"></script>
    <script>
        //        alert($);
        $(function () {
//            alert($);
            $(".do_login").click(function (res) {
//                alert(1);
                var user_name=$('.user_name').val();
                var user_pwd=$('.user_pwd').val();
                var url="{{asset('thirdly_week_test/login')}}";
                var url_1="{{asset('thirdly_week_test/tianqi_view')}}";
                $.ajax({
                    url:url,
                    type:'get',
                    data:{user_name:user_name,user_pwd:user_pwd},
                    dataType:'json',
                    success:function (res) {
                        setCookie('token',res.token,120);
//                        console.log(res);return;

                        if(res.code==200){
                            alert(res.msg);//最好做个确定框 确定走一个路径 取消走一个路径
                            location.href=url_1;
                        }else{
                            alert(res.msg);return;
                        }
                    }
                })
            })
        })
    </script>
@endsection