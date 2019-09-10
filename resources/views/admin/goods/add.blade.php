@extends('bootstrap.admin')
@section('content')
    <table>
        <tr>
            <td>商品名称</td>
            <td><input type="text" class="goods_name" name="goods_name"></td>
        </tr>
        <tr>
            <td>商品价格</td>
            <td><input type="number" class="goods_price" name="goods_price"></td>
        </tr>
        <tr>
            <td>商品图片</td>
            <td><input type="file" class="goods_img" name="goods_img"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2" class="add"><button>添加商品</button></td>
        </tr>
    </table>
    <script>
        $(function(){
           $(".add").click(function(){
//             alert($);
               var goods_name=$(".goods_name").val();
               var goods_price=$(".goods_price").val();
               var fd= new FormData();
               var goods_img=$(".goods_img")[0].files[0];
//               console.log(file);return false;
               fd.append('goods_name',goods_name);
               fd.append('goods_price',goods_price);
               fd.append('goods_img',goods_img);
//               alert(goods_img);
               $.ajax({
                  url:"http://www.dijiuyue.com/api/goods/restful",
                   type:"POST",
                   data:fd,
                   contentType:false,
                   processData:false,
                   success:function (res) {
                       console.log(res);
                   }
               });
           });
        });
    </script>

@endsection