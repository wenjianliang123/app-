@extends('bootstrap.admin')
@section('content')
<input type="file" name="file" id='file'>
<input type="submit" value='提交' id="btn">
<img src="" id='img_show'>

<script type="text/javascript">
    //base64
    var base64Str;//这里定义 下面赋值 之后全局可调用
    var file_name;
    var file_size;
    var file_type;
    $("#file").on('change',function(){
        //模拟表单对象  FormData
        var file = $('[name="file"]')[0].files[0]; //获取到文件
//        console.log(file);return;
         file_name=file.name;
         file_size=file.size;
         file_type=file.type;
        var reader = new FileReader(); //h5
        reader.readAsDataURL(file); //读base编码后的url地址
        reader.onload = function()
        {
            base64Str = this.result;
//            console.log(this.result);
            $("#img_show").attr('src',this.result);
        }
    })

    $("#btn").on('click',function(){
//        console.log(base64Str);
        $.ajax({
            url:"http://www.dijiuyue.com/api/upload_Base64"+'?file_name='+file_name+"&file_size="+file_size+"&file_type="+file_type,
            data:{img:base64Str},
            dataType:"json",
            type:"POST",
            success:function(res){

            }
        })
    })
</script>
@endsection