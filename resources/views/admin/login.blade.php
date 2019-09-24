@extends("hadmin.admin")
@section('content')
    <form action="" class="form-group">
        <table align="center">
            <tr>
                <td>
                    <label for="exampleInputEmail1">用户名</label>
                </td>
                <td>
                    <input class="form-control admin_user_name" type="text" name="admin_user_name">
                </td>
            </tr>
            <tr>
                <td><label for="exampleInputEmail1">密码</label></td>
                <td>
                    <input class="form-control admin_user_pwd" type="text" name="admin_user_pwd">
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
    <script>
//        alert($);
        $(function () {
//            alert($);
            $(".do_login").click(function (res) {
//                alert(1);
                var admin_user_name=$('.admin_user_name').val();
                var admin_user_pwd=$('.admin_user_pwd').val();
                var url="{{asset('admin/do_login')}}";
                $.ajax({
                    url:url,
                    data:{admin_user_name:admin_user_name,admin_user_pwd:admin_user_pwd},
                    dataType:'json',
                    success:function (res) {
//                        console.log(res);
                        if(res.code==200){
                            location.href='{{asset('admin/goods/goods_list')}}';
                        }
                    }
                })
            })
        })
    </script>
@endsection