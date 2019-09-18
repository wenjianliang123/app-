@extends('hadmin.admin')
@section('content')
    <h3>货品添加</h3>
    <form action="{{url('admin/goods/goods_do_sku')}}" method="post">
        @csrf
        <input type="hidden" name="goods_id" value="{{$goods_id}}">
        <table width="100%" id="table_list" class='table table-bordered'>
            <tbody>
            <tr>
                <th colspan="20" scope="col">商品名称：{{$goods_info['goods_name']}}&nbsp;&nbsp;&nbsp;&nbsp;货号：ECS000075</th>
            </tr>

            <tr>
                <!-- start for specifications -->
                @foreach($attr_info as $k=>$v)
                    <td scope="col"><div align="center"><strong>{{$v[0]['attribute_name']}}</strong></div></td>
            @endforeach
            <!-- end for specifications -->
                <td class="label_2">货号</td>
                <td class="label_2">库存</td>
                <td class="label_2">&nbsp;</td>
            </tr>

            <tr id="attr_row">
                <!-- start for specifications_value -->
                @foreach($attr_info as $key =>$value)
                    <td align="center" style="background-color: rgb(255, 255, 255);">
                        <select name="attr_id_list[]">
                            <option value="" selected="">请选择...</option>
                            {{--循环两遍是因为属性值有多个而上面的属性名就一个所有上面就循环了一遍--}}
                            @foreach($value as $kk=>$vv)
                                <option value="{{$vv['attr_id']}}">{{$vv['attr_value']}}</option>
                            @endforeach
                        </select>
                    </td>
            @endforeach
            {{--<td align="center" style="background-color: rgb(255, 255, 255);">--}}
            {{--<select name="attr[214][]">--}}
            {{--<option value="" selected="">请选择...</option>--}}
            {{--<option value="土豪金">土豪金</option>--}}
            {{--<option value="太空灰">太空灰</option>--}}
            {{--</select>--}}
            {{--</td>--}}
            <!-- end for specifications_value -->
                <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="product_sn[]" value="" size="20"></td>
                <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="product_number[]" value="1" size="10"></td>
                <td style="background-color: rgb(255, 255, 255);"><input type="button" class="jiahao" value="[+]"></td>
            </tr>

            <tr>
                <td align="center" colspan="5" style="background-color: rgb(255, 255, 255);">
                    <input type="submit" class="button" value=" 保存 ">
                </td>
            </tr>
            </tbody>
        </table>
    </form>

    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <script>
        $(document).on('click','.jiahao',function (res) {
//            alert(1);
            $(this).parent().parent().clone();
            var val=$(this).val();
            if(val == "[+]"){
                //jquery clone 复制当前
                //复制之前 先把+变为-
                $(this).val("[-]");
                var tr_clone=$(this).parent().parent().clone();
                $(this).parent().parent().after(tr_clone);
                //复制之后 再把-变为+
                $(this).val("[+]");
            }else{
                $(this).parent().parent().remove();
            }

        });
    </script>
@endsection