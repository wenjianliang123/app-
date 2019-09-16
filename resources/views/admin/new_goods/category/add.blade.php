@extends("hadmin.admin")
@section("content")
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <form action="">
        <table>
            <tr>
                <td>分类名称</td>
                <td><input type="text" name="cate_name" class="cate_name"></td>
            </tr>
            <tr>
                <td>所属分类</td>
                <td>
                    <select name="parent_id" class="parent_id" id="">
                        <option value="0">顶级分类</option>
                        @foreach($data as $k =>$v)
                        <option value="{{$v->cate_id}}">
                            @php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$v['level'])@endphp  {{$v->cate_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2"><input type="button" class="add_cate" value="添加分类"></td>
            </tr>
        </table>
    </form>
    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <script>
        $(function(){
            $(".add_cate").on('click',function () {
               var cate_name=$(".cate_name").val();
               var parent_id=$(".parent_id").val();
               var url="http://www.dijiuyue.com/admin/goods/cate_do_add";
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:url,
                    type:"POST",
                    data:{cate_name:cate_name,parent_id:parent_id},
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