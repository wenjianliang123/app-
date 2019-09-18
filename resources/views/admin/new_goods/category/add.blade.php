@extends("hadmin.admin")
@section("content")
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <form action="">
        <table>
            <tr>
                <td>分类名称</td>
                <td>
                    <input type="text" name="cate_name" class="cate_name">
                        <span id="tishi"></span>
                </td>
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
                <td>是否显示</td>
                <td>
                    <input type="radio" name="is_show" class="is_show" checked value="1" >显示
                    <input type="radio" name="is_show" class="is_show" value="2">隐藏
                </td>
            </tr>
            <tr>
                <td>排序功能</td>
                <td><input type="number" class="cate_sort" name="cate_sort"></td>
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
            var verify=false;
            //js唯一性验证
            //失焦事件
            $(".cate_name").blur(function(){
                var cate_name=$(".cate_name").val();
//                alert(cate_name);
                var url="http://www.dijiuyue.com/admin/goods/cate_name_unique_verufy";
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:url,
                    type:"POST",
                    data:{cate_name:cate_name},
                    dataType:"json",
                    success:function (res) {
                        console.log(res);
                        if(res.code==707){
                            //分类名称已存在
//                            alert(res.msg);
                            tishi.innerHTML = "<font color='red'>抱歉，该分类名：" + cate_name + "&nbsp;已被添加，请更换！</font>"
                            verify=false;
//                            alert(verify);
                        }else if(res.code==200){
                            //分类名称不存在
//                            alert(res.msg);
                            tishi.innerHTML = "<font color='green'>恭喜，" + cate_name + " 可以添加！</font>"
                            verify=true;
                        }
                    }
                })
            });
//            alert(verify);


//                alert(verify);return;
                //ajax添加分类
                $(".add_cate").on('click',function () {
                    var cate_name=$(".cate_name").val();
                    var parent_id=$(".parent_id").val();
                    var is_show=$('input[type=radio][name=is_show]:checked').val()
                    var cate_sort=$(".cate_sort").val();
                    var url="http://www.dijiuyue.com/admin/goods/cate_do_add";
                    //非空验证
                    if(cate_name==''){
                        alert("分类名称不能为空"); return;
                    }
                    //唯一性验证
                    if(!verify) {
                        alert('该分类名称已存在');return;
                    }


                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:url,
                        type:"POST",
                        data:{cate_name:cate_name,parent_id:parent_id,is_show:is_show,cate_sort:cate_sort},
                        dataType:"json",
                        success:function (res) {
                            alert(res.msg);
                            if(res.code==200){
                                location.href='cate_list';
                            }
                            console.log(res);
                        }
                    })
                })


        });
    </script>

@endsection