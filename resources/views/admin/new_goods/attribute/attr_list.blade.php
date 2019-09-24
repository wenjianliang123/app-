@extends('hadmin.admin')
@section('content')
    <h3>属性展示</h3>
    <form action="">

        <label for="exampleInputEmail1">类型搜索：</label>
        <select name="type_id" class="form-control" style="height: auto;width: auto" id="type_info">
            <option value="">请选择</option>
            @foreach($type_info as $k =>$v)
           <option <?php if(!empty($_GET['type_id'])){if($_GET['type_id']==$v['type_id']){ echo "selected";}}?> value="{{$v['type_id']}}">{{$v['type_name']}}</option>
            @endforeach
        </select>
    </form>
    <div class="rgba">
        <table class="table table-striped" style="">
            <tr style="background-color: rgba(0,0,0,0.1);">
                <td>
                    全选、全不选:<input type="checkbox" name="all_box" id="all_box">
                    反选:<input type="checkbox" name="fanxuan" id="fanxuan">
                    <input type="button"  class=" btn btn-info pishan" value="批删">
                </td>
                <td>属性ID</td>
                <td>属性名称</td>
                <td>商品类型</td>
                <td>操作</td>
            </tr>
            <tbody class="cate_add">

            </tbody>
        </table>
        {{--<div name="pagination" class="pagination">--}}

        {{--</div>--}}


    </div>


    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <script>
        //定义一个地址 以后方便更改
        var url="http://www.dijiuyue.com/admin/goods/attr_index";
//        return false;
//        console.log(1111);
        var type_id=getUrlParam('type_id');
//        console.log(type_id);
        if(type_id!=''){

//            alert(type_id);
            //进入页面渲染
            $.ajax({
                url:url+"?type_id="+type_id,
                type:"GET",
                dataType:'json',
                success:function(res){
                    wjl_page(res)
                },

            });
        }else{

            $.ajax({
                url:url,
                type:"GET",
                dataType:'json',
                success:function(res){
                    wjl_page(res)
                },

            });
        }

        //全选\全不选
        $(document).on('click','#all_box',function () {
            if($(this).prop('checked')){
                $('.box').each(function(){
                    $('.box').prop('checked',true);
                });
            }else{
                $('.box').each(function(){
                    $('.box').prop('checked',false);
                });
            }
        });
        //反选
        $(document).on('click','#fanxuan',function () {
            backcheck();
        });
        //反选功能
        function backcheck() {//先得到所有的checkbox
            var box_arr = document.getElementsByName("box");//得到一组checkbox  相当于数组
            //循环这一组checkbox让每一个checkbox选中
            for (var i = 0; i < box_arr.length; i++) {
                var c = box_arr[i];//得到一个checkbox
                if (c.checked == true) {//如果当前的checkbox是选中的则不让其选中
                    box_arr[i].checked = false;
                } else {
                    box_arr[i].checked = true;
                }
            }
        }

        //批删
        $(document).on('click','.pishan',function () {
//            alldel();
            var attr_id='';
            var f=false;
            $('.box').each(function(){
                if($(this).prop('checked')){
                    attr_id += ','+$(this).val();
                    f=true;
                }
            });
//            alert(attr_id);
            //跳到删除的servlet里去
            if(f==true){
                if(confirm("您确认要删除吗？"))
//                    location.href="servlet/DelServlet?ids="+arr;
//                    alert(arr);
                    var url='attr_pishan';
                $.ajax({
                    url:url,
                    type:"GET",
                    data:{attr_id:attr_id},
                    dataType:'json',
                    success:function(res){
//                            wjl_page(res)
                        console.log(res);
                        if(res.code==200){
                            alert(res.msg);
                            $('.box').each(function(){
                                if($(this).prop('checked')){
                                    $(this).parent().parent().remove();
                                }
                            });
                        }else{
                            alert(res.msg);
                        }

                    },

                });
            }else{
                alert("请至少选中一条进行批量删除");
            }


        });

        //搜索  //切换类型时 转到对应属性列表
        $(document).on('change','#type_info',function (res) {
           var type_id=$(this).val();
           location.href='attr_list?type_id='+type_id;
        });

        //封装的刷新页面、构建页码
        function wjl_page(res) {
            var attribute_name=$("[name=attribute_name]").val();
            var type_id=$("[name=type_id]").val();
            $(".cate_add").empty();
            $.each(res.data,function(i,v){
                //定义一个空tr
                var tr=$("<tr style='background-color: rgba(0,0,0,0.1);'></tr>");

                //往tr里面内部后面追加
                tr.append("<td>"+"<input type='checkbox' value='"+v.attribute_id+"' name='box' class='box'>"+"</td>");
                tr.append("<td>"+v.attribute_id+"</td>");
                tr.append("<td>"+v.attribute_name+"</td>");
                tr.append("<td>"+v.type_name+"</td>");
                tr.append("<td>" +
                    "<a href='javascript:;' class='del btn btn-danger'  attribute_name='"+v.attribute_name+"'>删除</a>" +
                    "&nbsp||&nbsp" +
                    "<a href='javascript:;' class='find btn btn-success' attribute_name='"+v.attribute_name+"'>修改</a></td>");
                //填入空白tbody
                $(".cate_add").append(tr);
            });

        }

        //获取url中的参数
        function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
            if (r != null) return unescape(r[2]); return null; //返回参数值
        }
    </script>
@endsection

