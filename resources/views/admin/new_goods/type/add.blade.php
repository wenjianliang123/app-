@extends("hadmin.admin")
@section("content")
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <form action="">
        <table>
            <tr>
                <td>类型名称</td>
                <td><input type="text" name="type_name" class="type_name"></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"><input type="button" class="add_type" value="添加类型"></td>
            </tr>
        </table>
    </form>
    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <script>
        $(function(){
            $(".add_type").on('click',function () {
                var type_name=$(".type_name").val();
                var url="http://www.dijiuyue.com/admin/goods/type_do_add";
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:url,
                    type:"POST",
                    data:{type_name:type_name},
                    dataType:"json",
                    success:function (res) {
                        alert(res.msg);
                        console.log(res);
                    }
                })
            })
        });
    </script>

@endsection