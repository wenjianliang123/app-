@extends("hadmin.admin")
@section('content')
    <form action="{{url('admin/do_register')}}" method="get" class="form-group">
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
                <td><label for="exampleInputEmail1">确认密码</label></td>
                <td>
                    <input class="form-control admin_user_repwd" type="text" name="admin_user_repwd">
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <input type="submit" style="margin-left: 60px" align="center" class="btn btn-info do_register" value="注册">
                </td>
            </tr>
        </table>
    </form>
    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script>
        //        alert($);
        $(function () {
//            alert($);
            $(".do_register").click(function (res) {
//                alert(1);
                var admin_user_name=$('.admin_user_name').val();
                var admin_user_pwd=$('.admin_user_pwd').val();
                var admin_user_repwd=$('.admin_user_repwd').val();
                var url="{{asset('admin/do_register')}}";
                var flag=false;
                //两次密码对比
                if(admin_user_repwd==admin_user_pwd){
                    flag=true;
                }else{
                    flag=false;
                }
                if(flag!=true){
                    alert("两次密码不一致");
                    return false;
                }
//                return;

            })
        })
    </script>
@endsection