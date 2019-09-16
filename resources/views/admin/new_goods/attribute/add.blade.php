@extends("hadmin.admin")
@section("content")
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <form action="">
        <table>
            <tr>
                <td>属性名称</td>
                <td><input type="text" name="attribute_name" class="attribute_name"></td>
            </tr>
            <tr>
                <td>所属商品类型</td>
                <td>
                    <select name="type_id" class="type_id" id="">
                        @foreach($type_info as $v)
                        <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>属性是否可选:</td>
                <td>
                    &nbsp
                    <input type="radio" name="attribute_is" class="attribute_is"  value="1" checked>唯一属性：
                    <input type="radio" name="attribute_is" class="attribute_is" value="2">单选属性：
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"><input type="button" class="add_cate" value="添加属性"></td>
            </tr>
        </table>
    </form>
    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <script>
        $(function(){
            $(".add_cate").on('click',function () {
                var attribute_name=$(".attribute_name").val();
                var type_id=$(".type_id").val();
                var attribute_is=$('input[type=radio][name=attribute_is]:checked').val();
                var url="http://www.dijiuyue.com/admin/goods/attr_do_add";
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:url,
                    type:"POST",
                    data:{attribute_name:attribute_name,type_id:type_id,attribute_is:attribute_is},
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