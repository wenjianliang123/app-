@extends('hadmin.admin')
@section('content')
    <h3>商品展示</h3>
    <form action="" class="form-inline">
        <select name="cate_id" class="form-control cate_id" style="height: auto;width: auto" id="">
            <option value="">所有分类</option>
            @foreach($cate_info as $k =>$v)
                <option value="{{$v['cate_id']}}">{{$v['cate_name']}}</option>
            @endforeach
        </select>
        <input type="radio" name="on_sale" class="on_sale" value="1">上架
        <input type="radio" name="on_sale" class="on_sale" value="2">下架
        关键字：<input type="text" name="goods_name" class="form-control goods_name" style="height: auto;width: auto" id="">
        <input type="button" value="搜索" class="search_button">
    </form>
    <div class="rgba">
        <table class="table table-striped" style="">
            <tr style="background-color: rgba(0,0,0,0.1);">
                <td>商品ID</td>
                <td>商品名称</td>
                <td>商品货号</td>
                <td>商品价格</td>
                <td>上架</td>
                <td>进货</td>
                <td>操作</td>
            </tr>
            <tbody class="cate_add">

            </tbody>
        </table>
        {{--分页样式--}}
        <nav aria-label="Page navigation" >
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
        {{--分页样式--}}
    </div>

    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <script>
        //定义一个地址 以后方便更改
        var url="http://www.dijiuyue.com/admin/goods/goods_index";
        //进入页面渲染
        $.ajax({
            url:url,
            type:"GET",
            dataType:'json',
            success:function(res){
                wjl_page(res)
            },
        });
        //搜索
        $('.search_button').click(function(res){
//            alert(1);
//            alert($('.click_goods_name').text());
            var goods_name=$('.goods_name').val();
            var cate_id=$('.cate_id').val();
            var on_sale=$('input[type=radio][name=on_sale]:checked').val();
            $.ajax({
                url:url,
                type:"GET",
                data:{goods_name:goods_name,cate_id:cate_id,on_sale:on_sale},
                dataType:'json',
                success:function(res){
                    console.log(res);
                    wjl_page(res);

                },
            });
        });

        //即点即改 商品名称
        $(document).on('click','.click_goods_name',function (res) {
//           alert($(this).text());
            var _this = $(this);
            var old_val  = _this.html();//获取原来的值
//            alert(old_val);return;
            _this.parent().html("<input type='text' name=" + old_val + " class='focus' value=" + old_val + " />");
            $(".focus").focus();
            $('.focus').blur(function(){
                var _this = $(this);
                var new_val = _this.val();//修改完的值
//                alert(new_val);return;
                var goods_id = _this.parents().attr("goods_id");
//                alert(goods_id);return;
                $.get("http://www.dijiuyue.com/admin/goods/goods_jidianjigai",{goods_name: new_val, goods_id:goods_id}, function(msg) {
                    if(msg=='2'){
                        _this.parent().html('<b class="click">' + new_val + '</b>');
                    }else{
                        _this.parent().html('<b class="click">' + old_val + '</b>');
                    }
                })
            })
        });

        /*//即点即改 上架
        $(document).on('click','.click_on_sale',function (res) {
//           alert($(this).text());
            var _this = $(this);
            var old_val  = _this.html();//获取原来的值
//            alert(old_val);return;
            _this.parent().html("<input type='text' name=" + old_val + " class='focus' value=" + old_val + " />");
            $(".focus").focus();
            $('.focus').blur(function(){
                var _this = $(this);
                var new_val = _this.val();//修改完的值
//                alert(new_val);return;
                var goods_id = _this.parents().attr("goods_id");
//                alert(goods_id);return;
                $.get("http://www.dijiuyue.com/admin/goods/goods_jidianjigai_1",{on_sale: new_val, goods_id:goods_id}, function(msg) {
                    if(msg=='2'){
                        _this.parent().html('<b class="click">' + new_val + '</b>');
                    }else{
                        _this.parent().html('<b class="click">' + old_val + '</b>');
                    }
                })
            })
        });*/

        $(document).on('click','.click_on_sale',function (res) {
            var _this=$(this);
            var url='http://www.dijiuyue.com/admin/goods/goods_jidianjigai_1';
            var goods_id = _this.parents().attr("goods_id");
//            console.log(goods_id);return;
            $.ajax({
                url:url,
                type:"GET",
                data:{goods_id:goods_id},
                dataType:'json',
                success:function(res){
//                    console.log(res);
                    if(res.code==500){
                        alert(res.msg);return;
                    }else if(res.code==200){
                        if(_this.text() =="❌"){
                            _this.text("🏒");
                        }else{
                            _this.html("❌");
                        }
                    }

                },
            });
        });


        //ajax分页
        /**
         * 点击分页按钮
         * 获取分页页码
         * 发送ajax请求到后台接口
         * 渲染页面
         */
        $(document).on("click",".pagination a",function(){
            var page=$(this).attr("page");
            var goods_name=$(".goods_name").val();
            var cate_id=$(".cate_id").val();
            var on_sale=$('input[type=radio][name=on_sale]:checked').val();
//        alert(user_name);
            $.ajax({
                url:url,
                type:"GET",
                data:{page:page,goods_name:goods_name,cate_id:cate_id,on_sale:on_sale},
                dataType:'json',
                success:function(res){
                    wjl_page(res)
                },
            });

        })
        
        //封装的刷新页面、
        function wjl_page(res) {
            var goods_name=$("[name=goods_name]").val();
            $(".cate_add").empty();
            $.each(res.data.data,function(i,v){
//                alert(v.goods_id);return;
                //定义一个空tr
                var tr=$("<tr style='background-color: rgba(0,0,0,0.1);'></tr>");
                //往tr里面内部后面追加
                tr.append("<td>"+v.goods_id+"</td>");
                tr.append("<td goods_id='"+v.goods_id+"'>"+"<b class='click_goods_name'>"+v.goods_name+"</b>"+"</td>");
                tr.append("<td>"+v.goods_sn+"</td>");
                tr.append("<td>"+v.goods_price+"</td>");
                tr.append("<td goods_id='"+v.goods_id+"'>"+"<b class='click_on_sale'>"+v.on_sale+"</b>"+"</td>");
                tr.append("<td>"+"<a href='goods_sku/"+v.goods_id+"'>为此商品进货</a>"+"</td>");

                tr.append("<td>" +
                    "<a href='javascript:;' class='del btn btn-danger'  goods_id='"+v.goods_id+"'>删除</a>" +
                    "&nbsp||&nbsp" +
                    "<a href='javascript:;' class='find btn btn-success' goods_id='"+v.goods_id+"'>修改</a></td>");
                //填入空白tbody
                $(".cate_add").append(tr);
            });
            //构建页码
            var page="";
//            console.log(res.data.last_page);return;
            // 根据页面返回的last_page参数循环  last_page是一共多少页
            for (var i=1;i<=res.data.last_page;i++)
            {
                //current_page是当前页
                if(i==res.data.current_page){
                    page+="<li class='active'><a href='javascript:;' style='color: #7adddd' page='"+i+"'>第"+i+"页</a></li>";
                }else{
                    page+="<li style=''><a href='javascript:;' page='"+i+"'>第"+i+"页</a></li>";
                }
            }
            //填入空白div 生成页码链接
            $(".pagination").html(page);
        }
    </script>
@endsection

